<div class="modal fade" id="settlementModal" tabindex="-1" aria-labelledby="settlementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:80%; max-width:80%;" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="settlementModalLabel">Settlement Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.accounting.receipt.settle', $receipt->receipt_voucher_id) }}" id="settlementForm">
                @csrf
                <div class="modal-body">
                    <table class="page-list-table" id="settlementTable">
                      <thead>
                          <tr>
                            <th style="width:20%;" >Label</th>
                            <th style="width:20%;" >Ledger A/c</th>
                            <th style="width:20%;" >Analytical Code</th>
                            <th style="width:20%;" >Narration</th>
                            <th style="width:10%; text-align:right;" >Debit</th>
                            <th style="width:10%; text-align:right;" >Credit</th>
                            <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                        <tr class="advance_account">
                            <td><b>Advance A/c</b></td>
                            <td><input type="hidden" name="settlement[ledger_account][]" value="{{ $receipt->to_account_code }}" >{{ $receipt->toAccount->account_name }}</td>
                            <td><input type="hidden" name="settlement[analytical_code][]" value="{{ $receipt->to_analytical_code }}" >{{ $receipt->analytical_code }}</td>
                            <td><input type="hidden" name="settlement[narration][]" value="" >{{ $receipt->narration }}</td>
                            <td><input type="hidden" name="settlement[debit][]" value="0" class="text-right" readonly></td>
                            <td><input type="text" name="settlement[credit][]" value="{{ $receipt->requested_amount }}" class="text-right" readonly></td>
                            <td></td>
                        </tr>
                        <tr class="dr_account">
                            <td><b><span class="cr_account_label" >Cash/Bank</span> A/c</b></td>
                            <td><input type="hidden" name="settlement[ledger_account][]" value="{{ $receipt->from_account_code }}" >{{ $receipt->fromAccount->account_name }}</td>
                            <td><input type="hidden" name="settlement[analytical_code][]" value="{{ $receipt->from_analytical_code }}" >{{ $receipt->analytical_code }}</td>
                            <td><input type="hidden" name="settlement[narration][]" value="" >{{ $receipt->narration }}</td>
                            <td><input type="text" name="settlement[debit][]" value="{{ $receipt->requested_amount }}" class="text-right" readonly></td>
                            <td><input type="hidden" name="settlement[credit][]" value="0" class="text-right" readonly></td>
                            <td></td>
                        </tr>
                      </tbody>
                    </table>

                    <br />
                    <button type="button" class="btn btn-save btn-sm float-right" id="addSettlementRow">Add More Expense</button>
                    <div style="clear:both;" ></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-close" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-save">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const advanceAmount = {{ $receipt->requested_amount ?? 0 }};

function updateCashBankDebit() {
  let totalExpense = 0;

  // Sum all expense account credit cells
  document.querySelectorAll('#settlementTable tbody .expense_account input[name="settlement[debit][]"]').forEach(input => {
    totalExpense += parseFloat(input.value) || 0;
  });

  // Calculate remaining
  let remaining = advanceAmount - totalExpense;
  if (remaining < 0) remaining = 0;

  // Update Cash/Bank debit cell
  const cashDebitInput = document.querySelector('#settlementTable tbody .dr_account input[name="settlement[debit][]"]');
  if (cashDebitInput) {
    cashDebitInput.value = remaining.toFixed(2);
  }
}

document.getElementById('addSettlementRow').addEventListener('click', function() {
  const tableBody = document.querySelector('#settlementTable tbody');
  const requestedAmount = {{ $receipt->requested_amount ?? 0 }};

  // Remove empty message if present
  const emptyRow = tableBody.querySelector('.empty-row');
  if (emptyRow) {
    emptyRow.remove();
  }

  // Create new Expense Account row
  const row = document.createElement('tr');
  row.classList.add('expense_account');

  row.innerHTML = `
    <td><b>Expense A/c</b></td>
    <td>
      <select name="settlement[ledger_account][]" class="select2" required>
        <option value="">- Select -</option>
        @foreach($accountTo as $account)
          <option value="{{ $account->value }}">{{ $account->label }}</option>
        @endforeach
      </select>
    </td>
    <td>
      <select name="settlement[analytical_code][]" class="select2">
        <option value="">- Select -</option>
        @foreach($analyticals as $analytical)
          <option value="{{ $analytical->analytical_code }}">{{ $analytical->analytical_code }}</option>
        @endforeach
      </select>
    </td>
    <td>
      <input type="text" name="settlement[narration][]" >
    </td>
    <td>
      <input type="number" step="0.01" name="settlement[debit][]" value="0" class="text-end expense-debit" required>
    </td>
    <td><input type="hidden" name="settlement[credit][]" value="0" class="text-right" readonly></td>
    <td>
      <button type="button" class="btn btn-danger btn-sm remove-settlement-row">X</button>
    </td>
  `;

  // Find the Cash/Bank (dr_account) row
  const drAccountRow = tableBody.querySelector('.dr_account');

  if (drAccountRow) {
    // Insert before the dr_account row
    tableBody.insertBefore(row, drAccountRow);
  } else {
    // Fallback: append to the end if dr_account row not found
    tableBody.appendChild(row);
  }

  // Re-initialize select2 for the new select
  $(row).find('.select2').select2({
    dropdownParent: $('#settlementModal')
  });

  // Attach event listener for debit input
  row.querySelector('input[name="settlement[debit][]"]').addEventListener('input', updateCashBankDebit);
});

document.addEventListener('click', function(e) {
  if (e.target && e.target.classList.contains('remove-settlement-row')) {
    const row = e.target.closest('tr');
    const tableBody = row.parentElement;
    row.remove();

    updateCashBankDebit();
  }
});

document.getElementById('settlementForm').addEventListener('submit', function (e) {
    let total = 0;
    const amountInputs = document.querySelectorAll('input[name="settlement[amount][]"]');

    amountInputs.forEach(input => {
        const value = parseFloat(input.value) || 0;
        total += value;
    });

    if (total > requestedAmount) {
        e.preventDefault();
        alert(`Total settlement amount (${total.toFixed(2)}) exceeds the requested amount (₹${requestedAmount.toFixed(2)}).`);
    }
});

</script>
