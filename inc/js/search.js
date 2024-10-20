document.addEventListener('DOMContentLoaded', function() {        

    // Attach event listeners to all filter fields
    const filterFields = [
        document.getElementById('keyword'),
        document.getElementById('account_type'),
        document.getElementById('individual_type'),
        document.getElementById('countries'),
        document.getElementById('languages'),
        document.getElementById('research_seeking'),
        document.getElementById('research_offering'),
        document.getElementById('professional')
    ];

    filterFields.forEach(field => {
        if (field) {
            field.addEventListener('change', fetchProfiles);
            field.addEventListener('keyup', fetchProfiles);
        }
    });

    function fetchProfiles() {
        const ajaxUrl = document.getElementById('ajax_url').value;
        const searchResults = document.getElementById('search-results');
        const resultsCounter = document.getElementById('results_counter');
        const keyword = document.getElementById('keyword').value;
        const account_type = Array.from(document.getElementById('account_type').selectedOptions).map(option => option.value);
        const individual_type = Array.from(document.getElementById('individual_type').selectedOptions).map(option => option.value);
        const countries = Array.from(document.getElementById('countries').selectedOptions).map(option => option.value);
        const languages = Array.from(document.getElementById('languages').selectedOptions).map(option => option.value);
        const collaborating = Array.from(document.getElementById('collaborating').selectedOptions).map(option => option.value);
        const research = Array.from(document.getElementById('research_interests').selectedOptions).map(option => option.value);

        //show individual options if needed
        const individual_type_select = document.getElementById('individual_type');
        if (account_type.includes('Individual')) {
            individual_type_select.removeAttribute('disabled');
        } else {
            individual_type_select.setAttribute('disabled', 'disabled');
        }

        // Check if all fields are empty
        if (!keyword && account_type.length === 0 && countries.length === 0 && languages.length === 0 && collaborating.length === 0 && research.length === 0) {
            searchResults.innerHTML = '<div class="alert alert-primary">Please either enter a search term or select an option above</div>';
            return; // Exit if all fields are empty
        }
    
        const data = new FormData();
        data.append('action', 'search_profiles');
        data.append('security', localData.ajax_nonce);
        data.append('keyword', keyword);
        data.append('account_type', JSON.stringify(account_type));
        data.append('individual_type', JSON.stringify(individual_type));
        data.append('countries', JSON.stringify(countries));
        data.append('languages', JSON.stringify(languages));
        data.append('collaborating', JSON.stringify(collaborating));
        data.append('research', JSON.stringify(research));
        
        fetch(ajaxUrl, {
            method: 'POST',
            body: data
        })
        .then(response => response.json())
        .then(response => {
            const searchResults = document.getElementById('search-results');
            searchResults.innerHTML = '';
    
            if (response.success) {
                response.data.forEach(profileHtml => {
                    const profileDiv = document.createElement('div');
                    profileDiv.classList.add('col-xl-4'); // Add Bootstrap class
                    profileDiv.innerHTML = profileHtml;
                    searchResults.appendChild(profileDiv);
                });
                resultsCounter.textContent = `Showing ${response.data.length} results`;
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
                })
            } else {
                searchResults.innerHTML = '<p>No profiles found.</p>';
                resultsCounter.textContent = `Showing 0 results`;

            }
        })
        .catch(error => console.error('Error:', error));
    }

    function initializeSelect2() {
        jQuery('#account_type').select2({
            placeholder: "Account Types",
        }).on('change', fetchProfiles);
        jQuery('#individual_type').select2({
            placeholder: "Individual Types",
        }).on('change', fetchProfiles);
        jQuery('#countries').select2({
            placeholder: "Countries",
        }).on('change', fetchProfiles);
    
        jQuery('#languages').select2({
            placeholder: "Languages",
        }).on('change', fetchProfiles);
        jQuery('#collaborating').select2({
            placeholder: "Collaborating on...",
        }).on('change', fetchProfiles);

        jQuery('#research_interests').select2({
            placeholder: "Research Interests",
            minimumInputLength: 3,
            ajax: {
                url: jQuery('#ajax_url').val(), // Your AJAX URL
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        action: 'ajax_search_research_interests', // Custom action hook
                        security_nonce_research: jQuery('#security_nonce_research').val()
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        }).on('change', fetchProfiles);
    }
    initializeSelect2();

    jQuery(window).resize(function() {
        initializeSelect2(); // Reinitialize Select2
     });

    
 
    
    
});