
$(document).ready(function() {
    $('.appselect2').select2();
});




window.addEventListener('DOMContentLoaded', event => {

// Toggle the side navigation
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

    window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }
});


    $(document).ready(function() {
     $('#dataTable').DataTable();
     });
       

       var message = "{{ Session::get('message') }}";
    if (message) {
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':

                    toastr.options.timeOut = 10000;
                    toastr.info("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();
                    break;
                case 'success':

                    toastr.options.timeOut = 10000;
                    toastr.success("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
                case 'warning':

                    toastr.options.timeOut = 10000;
                    toastr.warning("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
                case 'error':

                    toastr.options.timeOut = 10000;
                    toastr.error("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
            }}

  $(document).ready(function() {
    $('#com_h_SearchButton').click(function() {
       
      // Get the values from the input fields
      var searchTerm1 = $('#com_h_name').val();
      var searchTerm2 = $('#com_h_phone').val();
    
      if(searchTerm1 || searchTerm2){
        $.ajax({
        type: 'GET',
        url: '/com_hs/search', // Replace with your actual search endpoint
        data: { term1: searchTerm1, term2: searchTerm2 },
        success: function(data) {
        //     if(data){
        //  alert(data);}
        //  else{
        //     alert('no data'); 
        //  }
          // Update the search results in the dropdown menu
          displaySearchResults(data);
        }
      });
    }else{
        toastr['error']('Ooops!! Kindly enter either a name or a phone number');
      
      }
    });
      
      // Call the search method in the controller using Ajax
     

    // Handle item selection in the search results
    $('#com_hSearchResults').on('click', '.search-item', function() {
    var selectedValue = $(this).data('id');
    var selectedDisplayName = $(this).text();
    var displayPhone = $(this).data('com_h_phone'); 

    // Update input fields with the selected values
    $('#com_h_name').val(selectedDisplayName);
    $('#com_h_user_id').val(selectedValue);

    // Use the correct variable name here
    $('#com_h_phone').val(displayPhone);

    // Clear the search results dropdown
    $('#com_hSearchResults').empty();
});
    function displaySearchResults(results) {
   // console.log(results); // Log the results to the console

    var $searchResults = $('#com_hSearchResults');
    $searchResults.empty();

    if (results.length > 0) {
      console.log(results);
        results.forEach(function(result) {
            // Append list item directly without creating a jQuery object
            $searchResults.append(
    '<li class="dropdown-item search-item bg-primary text-white" data-id="' + result.id + '" data-com_h_phone="' + result.displayPhone + '">' + 
    result.displayName + ' (' + result.displayPhone + ')</li>'
);


        });
        $searchResults.show();  // Show the dropdown if there are results
    } else {
        toastr['error']('Ooops!! The community health worker with the given details does not exist');
    }
}

  });


  $(document).ready(function() {
    $('#hospitalSearchButton').click(function() {
       
      // Get the values from the input fields
      var searchTerm1 = $('#hospital_name').val();
      var searchTerm2 = $('#hospital_phone').val();
    
      if(searchTerm1 || searchTerm2){
        $.ajax({
        type: 'GET',
        url: '/hospitals/search', // Replace with your actual search endpoint
        data: { term1: searchTerm1, term2: searchTerm2 },
        success: function(data) {
        //     if(data){
        //  alert(data);}
        //  else{
        //     alert('no data'); 
        //  }
          // Update the search results in the dropdown menu
          displaySearchResults(data);
        }
      });
    }else{
        toastr['error']('Ooops!! Kindly enter either a name or a phone number');
      
      }
    });
      
      // Call the search method in the controller using Ajax
     

    // Handle item selection in the search results
    $('#hospitalSearchResults').on('click', '.search-item', function() {
    var selectedValue = $(this).data('id');
    var selectedDisplayName = $(this).text();
    var displayPhone = $(this).data('hospital_phone'); 

    // Update input fields with the selected values
    $('#hospital_name').val(selectedDisplayName);
    $('#hosp_h_user_id').val(selectedValue);

    // Use the correct variable name here
    $('#hospital_phone').val(displayPhone);

    // Clear the search results dropdown
    $('#hospitalSearchResults').empty();
});
    function displaySearchResults(results) {
   // console.log(results); // Log the results to the console

    var $searchResults = $('#hospitalSearchResults');
    $searchResults.empty();

    if (results.length > 0) {
      console.log(results);
        results.forEach(function(result) {
            // Append list item directly without creating a jQuery object
            $searchResults.append(
    '<li class="dropdown-item search-item bg-primary text-white" data-id="' + result.id + '" data-hospital_phone="' + result.displayPhone + '">' + 
    result.displayName + ' (' + result.displayPhone + ')</li>'
);


        });
        $searchResults.show();  // Show the dropdown if there are results
    } else {
        toastr['error']('Ooops!! The hospital with the given details does not exist');
    }
}

  });


  $(document).ready(function() {
    $('#parentSearchButton').click(function() {
        console.log('parent button');
      // Get the values from the input fields
      var searchTerm1 = $('#parent_name').val();
      var searchTerm2 = $('#parent_phone').val();
    
      if(searchTerm1 || searchTerm2){
        $.ajax({
        type: 'GET',
        url: '/parents/search', // Replace with your actual search endpoint
        data: { term1: searchTerm1, term2: searchTerm2 },
        success: function(data) {
        //     if(data){
        //  alert(data);}
        //  else{
        //     alert('no data'); 
        //  }
          // Update the search results in the dropdown menu
          displaySearchResults(data);
        }
      });
    }else{
        toastr['error']('Ooops!! Kindly enter either a name or a phone number');
      
      }
    });
      
      // Call the search method in the controller using Ajax
     

    // Handle item selection in the search results
    $('#parentSearchResults').on('click', '.search-item', function() {
    var selectedValue = $(this).data('id');
    var selectedDisplayName = $(this).text();
    var displayPhone = $(this).data('parent_phone'); 

    // Update input fields with the selected values
    $('#parent_name').val(selectedDisplayName);
    $('#parent_id').val(selectedValue);

    // Use the correct variable name here
    $('#parent_phone').val(displayPhone);

    // Clear the search results dropdown
    $('#parentSearchResults').empty();
});
    function displaySearchResults(results) {
   // console.log(results); // Log the results to the console

    var $searchResults = $('#parentSearchResults');
    $searchResults.empty();

    if (results.length > 0) {
      console.log(results);
        results.forEach(function(result) {
            // Append list item directly without creating a jQuery object
            $searchResults.append(
    '<li class="dropdown-item search-item bg-primary text-white" data-id="' + result.id + '" data-parent_phone="' + result.displayPhone + '">' + 
    result.displayName + ' (' + result.displayPhone + ')</li>'
);


        });
        $searchResults.show();  // Show the dropdown if there are results
    } else {
        toastr['error']('Ooops!! The parent with the given details does not exist');
    }
}

  });
