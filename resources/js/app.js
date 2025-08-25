/**
 * 1️⃣ Import jQuery first and set it globally
 */
import $ from 'jquery';
window.$ = window.jQuery = $;

/**
 * 2️⃣ Now import jQuery-dependent plugins
 */
import 'datatables.net-bs4';
import 'select2';
import '/public/js/custom.js';
import '/public/vendor/adminlte/dist/js/adminlte.min.js';
import '/public/vendor/bootstrap/js/bootstrap.bundle.min.js';
import '/public/vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js';

/**
 * 3️⃣ Import all CSS
 */
import 'datatables.net-bs4/css/dataTables.bootstrap4.min.css';
import 'select2/dist/css/select2.min.css';
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import '/public/css/custom.css';
import '/public/vendor/adminlte/dist/css/adminlte.min.css';
import '/public/vendor/fontawesome-free/css/all.min.css';
import '/public/vendor/overlayScrollbars/css/OverlayScrollbars.min.css';

/**
 * 4️⃣ Import FilePond and plugins
 */
import * as FilePond from 'filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';

FilePond.registerPlugin(
  FilePondPluginFileValidateType,
  FilePondPluginFileValidateSize,
  FilePondPluginImagePreview
);

window.FilePond = FilePond;

/**
 * 5️⃣ DOM Ready
 */
$(function () {
  console.log('✅ jQuery is loaded and ready!');
  $('.datatable').DataTable();
  $('.select2').select2({
        placeholder: '- Select -',
        allowClear: true,
        width: '100%'
    });
});
