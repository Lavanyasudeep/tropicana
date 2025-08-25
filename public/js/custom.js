$(document).ready(function() {
    $('.select2').select2({
        placeholder: '- Select -',
        allowClear: true,
        width: '100%'
    });

    $(document).on('click', '.select-val', function(){
      $(this).focus().select();
    });
});

function checkPageFormValidate(form_id) {
    var isValid = true;
    $('#'+form_id).find('.pform-required-error').removeClass('pform-required-error');

    // input field
    $('#'+form_id).find('input.pform-required').each(function(){
        if($(this).val().trim()=='' || $(this).val().trim()==0) {
            $(this).addClass('pform-required-error');
            isValid = false;
        }
    });

    // select field
    $('#'+form_id).find('select.pform-required').each(function(){
        if($(this).find('option:selected').val().trim()=='' || $(this).find('option:selected').val().trim()==0) {
            $(this).addClass('pform-required-error');
            isValid = false;
        }
    });

    if(!isValid)
        toastr.error("Please enter a requied fields.","Form Validation Error");

    return isValid;
}

function showConfirmationModal(title, message, onYes, onNo) {
    // Remove existing modal if it exists
    const existingModal = document.getElementById('confirmationModal');
    if (existingModal) {
      existingModal.remove();
    }
  
    // Create modal HTML
    const modalHTML = `
      <div id="confirmationModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color:#943524;" >
              <h5 class="modal-title">${title}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body text-center">
                <br />
                <p>${message}</p>
            </div>
            <div class="modal-footer">
              <button id="noBtn" type="button" class="btn btn-default" data-dismiss="modal">No</button>
              <button id="yesBtn" type="button" class="btn btn-primary">Yes</button>
            </div>
          </div>
        </div>
      </div>
    `;
  
    // Insert modal into the DOM
    document.body.insertAdjacentHTML('beforeend', modalHTML);
  
    // Add event listeners
    document.getElementById('yesBtn').addEventListener('click', () => {
      if (typeof onYes === 'function') onYes();
      $('#confirmationModal').modal('hide');
    });
  
    document.getElementById('noBtn').addEventListener('click', () => {
      if (typeof onNo === 'function') onNo();
      $('#confirmationModal').modal('hide');
    });
  
    // Show the modal using jQuery (Bootstrap 4)
    $('#confirmationModal').modal('show');
  
    // Cleanup after modal is hidden
    $('#confirmationModal').on('hidden.bs.modal', function () {
      document.getElementById('confirmationModal').remove();
    });
} 