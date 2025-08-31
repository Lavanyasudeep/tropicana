<div class="modal fade" id="settlementModal" tabindex="-1" aria-labelledby="settlementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" style="width:80%; max-width:80%;" >
        <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="modal-title" id="settlementModalLabel">
                    <i class="fas fa-file-invoice-dollar"></i> Settlement Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <form method="POST" action="{{ route('admin.accounting.receipt.settle', $receipt->receipt_voucher_id) }}" id="settlementForm">
                @csrf
                <div class="modal-body">
                    <!-- Inline validation alert -->
                    <div id="settlementAlert" class="alert alert-danger d-none"></div>

                    <table class="page-list-table" id="settlementTable">
                        <thead class="table-light">
                            <tr>
                                <th style="width:18%;">Label</th>
                                <th style="width:20%;">Ledger A/c</th>
                                <th style="width:20%;">Analytical Code</th>
                                <th style="width:20%;">Narration</th>
                                <th style="width:10%; text-align:right;">Debit</th>
                                <th style="width:10%; text-align:right;">Credit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="advance_account table-success fw-bold">
                                <td><b>Advance A/c</b></td>
                                <td>
                                    <input type="hidden" name="settlement[ledger_account][]" value="{{ $receipt->to_account_code }}">
                                    {{ $receipt->toAccount->account_name }}
                                </td>
                                <td>
                                    <input type="hidden" name="settlement[analytical_code][]" value="{{ $receipt->to_analytical_code }}">
                                    {{ $receipt->analytical_code }}
                                </td>
                                <td>
                                    <input type="hidden" name="settlement[narration][]" value="">
                                    {{ $receipt->narration }}
                                </td>
                                <td><input type="hidden" name="settlement[debit][]" value="0" readonly></td>
                                <td class="text-end">
                                    <input type="text" name="settlement[credit][]" value="{{ $receipt->requested_amount }}" class="form-control form-control-sm text-end" readonly>
                                </td>
                                <td></td>
                            </tr>

                            <tr class="dr_account table-success fw-bold">
                                <td><b>Cash/Bank A/c</b></td>
                                <td>
                                    <input type="hidden" name="settlement[ledger_account][]" value="{{ $receipt->from_account_code }}">
                                    {{ $receipt->fromAccount->account_name }}
                                </td>
                                <td>
                                    <input type="hidden" name="settlement[analytical_code][]" value="{{ $receipt->from_analytical_code }}">
                                    {{ $receipt->analytical_code }}
                                </td>
                                <td>
                                    <input type="hidden" name="settlement[narration][]" value="">
                                    {{ $receipt->narration }}
                                </td>
                                <td class="text-end">
                                    <input type="text" name="settlement[debit][]" value="{{ $receipt->requested_amount }}" class="form-control form-control-sm text-end" readonly>
                                </td>
                                <td><input type="hidden" name="settlement[credit][]" value="0" readonly></td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Total</td>
                                <td class="text-end" id="totalDebit">0.00</td>
                                <td class="text-end" id="totalCredit">0.00</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="mt-2 d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-primary btn-sm" id="addSettlementRow">
                            <i class="fas fa-plus"></i> Add Expense
                        </button>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Close
                    </button>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-save"></i> Save Settlement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const advanceAmount = {{ $receipt->requested_amount ?? 0 }};

// Calculate total Debit/Credit
function updateTotals() {
    let totalDebit = 0;
    let totalCredit = 0;

    document.querySelectorAll('input[name="settlement[debit][]"]').forEach(input => {
        totalDebit += parseFloat(input.value) || 0;
    });

    document.querySelectorAll('input[name="settlement[credit][]"]').forEach(input => {
        totalCredit += parseFloat(input.value) || 0;
    });

    document.getElementById('totalDebit').textContent = totalDebit.toFixed(2);
    document.getElementById('totalCredit').textContent = totalCredit.toFixed(2);
}

// Show inline error
function showSettlementError(message) {
    const alertDiv = document.getElementById('settlementAlert');
    alertDiv.classList.remove('d-none');
    alertDiv.textContent = message;
}

// Hide error
function hideSettlementError() {
    document.getElementById('settlementAlert').classList.add('d-none');
}

// Add expense row
document.getElementById('addSettlementRow').addEventListener('click', function () {
    const tableBody = document.querySelector('#settlementTable tbody');

    const row = document.createElement('tr');
    row.classList.add('expense_account');

    row.innerHTML = `
        <td><b>Expense A/c</b></td>
        <td>
            <select name="settlement[ledger_account][]" class="form-select form-select-sm select2" required>
                <option value="">- Select -</option>
                @foreach($accountTo as $account)
                    <option value="{{ $account->value }}">{{ $account->label }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="settlement[analytical_code][]" class="form-select form-select-sm select2">
                <option value="">- Select -</option>
                @foreach($analyticals as $analytical)
                    <option value="{{ $analytical->analytical_code }}">{{ $analytical->analytical_code }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" name="settlement[narration][]" class="form-control form-control-sm">
        </td>
        <td>
            <input type="number" step="0.01" name="settlement[debit][]" value="0" class="form-control form-control-sm text-end expense-debit" required>
        </td>
        <td>
            <input type="hidden" name="settlement[credit][]" value="0">
        </td>
        <td>
            <button type="button" class="btn btn-outline-danger btn-sm remove-settlement-row">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    `;

    // Insert above dr_account row
    const drRow = tableBody.querySelector('.dr_account');
    tableBody.insertBefore(row, drRow);

    // Initialize select2
    $(row).find('.select2').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#settlementModal')
    });

    // Listen for input changes
    row.querySelector('input[name="settlement[debit][]"]').addEventListener('input', () => {
        updateCashBankDebit();
        updateTotals();
        hideSettlementError();
    });

    updateCashBankDebit();
    updateTotals();
});

// Update Cash/Bank (dr_account) debit value
function updateCashBankDebit() {
    let totalExpense = 0;

    document.querySelectorAll('.expense_account input[name="settlement[debit][]"]').forEach(input => {
        totalExpense += parseFloat(input.value) || 0;
    });

    let remaining = advanceAmount - totalExpense;
    if (remaining < 0) remaining = 0;

    const cashInput = document.querySelector('.dr_account input[name="settlement[debit][]"]');
    if (cashInput) {
        cashInput.value = remaining.toFixed(2);
    }
}

// Remove row
document.addEventListener('click', function (e) {
    if (e.target.closest('.remove-settlement-row')) {
        const row = e.target.closest('tr');
        row.remove();
        updateCashBankDebit();
        updateTotals();
        hideSettlementError();
    }
});

// Form submission validation
document.getElementById('settlementForm').addEventListener('submit', function (e) {
    let totalDebit = 0;

    document.querySelectorAll('input[name="settlement[debit][]"]').forEach(input => {
        totalDebit += parseFloat(input.value) || 0;
    });

    if (totalDebit > advanceAmount) {
        e.preventDefault();
        showSettlementError(`Total settlement amount (₹${totalDebit.toFixed(2)}) exceeds the requested advance (₹${advanceAmount.toFixed(2)}).`);
    }
});

// Initial call on modal open
document.addEventListener('DOMContentLoaded', function () {
    updateTotals();
});
</script>

