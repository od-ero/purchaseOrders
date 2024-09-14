//  import $ from 'jquery';

	$(document).ready(function() {
  

 // $('.appselect2').select2();

 
$('input').on('keyup change', function() {
$(this).removeClass('is-invalid');
$(this).next('.invalid-feedback').remove();
});

$('select').on('change', function() {
$(this).removeClass('is-invalid');
$(this).next('.invalid-feedback').remove();
});



});





window.addEventListener('DOMContentLoaded', event => {


const sidebarToggle = document.body.querySelector('#sidebarToggle');
if (sidebarToggle) {
  // Uncomment Below to persist sidebar toggle between refreshes
  // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
  //     document.body.classList.toggle('sb-sidenav-toggled');
  // }
  sidebarToggle.addEventListener('click', event => {
      event.preventDefault();
      document.body.classList.toggle('sb-sidenav-toggled');
      localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
  });
}

});

document.addEventListener('DOMContentLoaded', function () {
// Check if there is a message in session storage
var successMessage = sessionStorage.getItem('successMessage');
var errorMessage = sessionStorage.getItem('errorMessage');
if (successMessage) {
    alertify.set('notifier', 'position', 'top-center');
    alertify.success(successMessage ,10);

    
    sessionStorage.removeItem('successMessage');
}

if (errorMessage) {
  alertify.set('notifier', 'position', 'top-center');
  alertify.error(errorMessage ,5);

  
  sessionStorage.removeItem('errorMessage');
}

   $('#dataTable').DataTable();
});
