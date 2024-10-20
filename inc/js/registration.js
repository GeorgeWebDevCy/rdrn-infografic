
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('registration_form');
    const steps = form.querySelectorAll('div.step');
    const previousButton = document.querySelector('.previous_reg');
    const nextButton = document.querySelector('.next_reg');
    const completeButton = document.querySelector('.complete_reg');
    const allInputs = form.querySelectorAll('input, select, textarea'); 
    const completeDiv = document.querySelector('.complete');
    let initialRegistrationComplete = false;
    const ajaxUrlInput = document.getElementById('ajax_url').value;
    let currentStep = 1;

    //attach a change event for all inputs
    allInputs.forEach(input => {
        input.addEventListener('change', handleInputChange);
        input.addEventListener('keyup', handleInputChange);

    });


    // Function to activate a specific step
    function activateStep(stepNumber) {
        console.log('active step.....'+stepNumber);
        steps.forEach(step => step.classList.remove('active'));
        let activeStep = document.querySelector(`.step[data-step-number="${stepNumber}"]`);
        activeStep.classList.add('active');
        let currentStep = stepNumber;

        // Update button visibility
        previousButton.classList.toggle('d-none', stepNumber === 1);
        nextButton.classList.toggle('d-none', stepNumber === steps.length);
        completeButton.classList.toggle('d-none', stepNumber !== steps.length);

        //verify this step's fields
        verifyStep(stepNumber);

        //hide complete msg
        completeDiv.classList.add('d-none');

        //progress bar
        const totalSteps = steps.length;
        const progressPercentage = (stepNumber - 1) / (totalSteps - 1) * 100; // Calculate progress percentage
        const progressBar = document.querySelector('.progress-bar');
        progressBar.style.width = `${progressPercentage}%`; // Set the width of the progress bar
        progressBar.setAttribute('aria-valuenow', progressPercentage); // Update aria label
    }

    // Event Listeners for next prev buttons
    previousButton.addEventListener('click', () => {
        let stepNumber = parseInt(document.querySelector('.step.active').getAttribute('data-step-number'), 10);
        currentStep=stepNumber;
        currentStep--; // Decrement current step
        activateStep(currentStep);
    });
    nextButton.addEventListener('click', () => {
        let stepNumber = parseInt(document.querySelector('.step.active').getAttribute('data-step-number'), 10);
        currentStep=stepNumber;
        currentStep++; // Increment current step
        activateStep(currentStep);
    });

    function handleInputChange(event) {
        //console.log('handleInputChange');
        const currentStep = parseInt(event.target.closest('.step').dataset.stepNumber, 10);
        if (currentStep) { // Check if a step element was found
          verifyStep(currentStep);
        }
    }

    //step verifications
    function verifyStep(stepNumber) {

        //console.log('verifyStep');

        const stepElement = form.querySelector(`.step[data-step-number="${stepNumber}"]`);
      
        let allFieldsValid = false;
      
        // Step 1
        if (stepNumber === 1) {
            const atLeastOneChecked = stepElement.querySelectorAll('.btn-check:checked').length > 0;
            allFieldsValid = atLeastOneChecked; 

            const individual = document.getElementById('type-individual');
            const individual_options = document.getElementById('type-individual-option');
            //if individual is selected make sure to show the dropdown and that its not left empty
            if (individual.checked) {
                //verification
                allFieldsValid = false;
                individual_options.classList.remove('d-none');
                const checkedIndvidualOptions = document.querySelectorAll('#type-individual-option input[type="checkbox"]:checked');
                if (checkedIndvidualOptions.length > 0) {
                    allFieldsValid = true;
                    console.log('at least one is checked');
                } else {
                    allFieldsValid = false;
                    console.log('All field valid? '+allFieldsValid);
                }
            } else {
                //Hide individual dropdown 
                individual_options.classList.add('d-none');
            }

            //toggle role fields
            function toggleRoleField(checkboxId, roleFieldId) {
                const checkbox = document.getElementById(checkboxId);
                const roleField = document.getElementById(roleFieldId);
                if (checkbox.checked) {
                    roleField.classList.remove('d-none');
                    roleField.setAttribute('required', 'required');
                } else {
                    roleField.classList.add('d-none');
                    roleField.removeAttribute('required');
                }
            }
    
            // Apply the toggle function for each checkbox and role field pair
            document.querySelectorAll('.account_type_button').forEach(button => {
                const buttonId = button.id;
                // Skip the 'type-individual' button
                if (buttonId !== 'type-individual') {
                    toggleRoleField(buttonId, `${buttonId}-org`);
                    toggleRoleField(buttonId, `${buttonId}-role`);
                }
            });

            //check for empty role fields
            const roleFields = Array.from(document.querySelectorAll('.role_type_field')).map(field => field.id);
            roleFields.forEach(roleFieldId => {
                const roleField = document.getElementById(roleFieldId);
            
                if (roleField && !roleField.classList.contains('d-none') && roleField.value.trim() === '') {
                    allFieldsValid = false;
                    //console.log(`${roleFieldId} is empty and visible.`);
                }
            });
            
   
        }

        //step 2 - Consent
        if (stepNumber === 2) {
            allFieldsValid = false;
            if (document.getElementById('consent-agree').checked) {
                allFieldsValid = true;
            } else {
                allFieldsValid = false;
            }
        }

        // Step 3  
        if (stepNumber === 3) {
            allFieldsValid = true;

            const requiredInputs = stepElement.querySelectorAll('input[required]');
            for (const input of requiredInputs) {
                if (input.value.trim() === "") { // Check if field is empty (trimmed)
                    allFieldsValid = false;
                    break; // Stop iterating if an empty field is found (optimization)
                }
            }

            // Validate emails and passwords
            if (!confirmEmail(document.getElementById('email')) || !confirmPassword(document.getElementById('password'))) {
                allFieldsValid = false; // Set to false if either validation fails
                //console.log('email or password checks failed.')
            }

            

            
        }

        //Step 4 - REGISTRATION OF USER ACCOUNT
        if (stepNumber === 4) {
            //console.log('You are now on step 4');

            //We should have all the details now to register their user account so run ajax
            if (!initialRegistrationComplete) {
                initialRegistration();
            } else {
                //console.log('Registration has already ran');
            }


            allFieldsValid = true; 
        

        }

        //Step 5
        if (stepNumber === 5) {
            allFieldsValid = true; 
            //console.log('You are now on step 5');

            //Listen for delte button clicks logo and row
            document.addEventListener('click', function(event) {
                const deleteButton = event.target.closest('.delete-link-btn');
                if (deleteButton) {
                    const linkDetails = deleteButton.closest('.profile_link');
                    if (linkDetails) {
                        linkDetails.remove();
                        updateLinkIndices(); 
                        showAddAnotherLinkButton(); 
                    }
                }
                
            });

        }

        //Step 6
        if (stepNumber === 6) {
            allFieldsValid = true; 
        }

        //Step 7
        if (stepNumber === 7) {
            allFieldsValid = true; 

            const researchInput = document.getElementById('research_ideas');
            let debounceTimer;
            
            researchInput.addEventListener('input', function() {
                const query = researchInput.value.trim();
            
                if (query.length >= 3) {
                    clearTimeout(debounceTimer);
            
                    debounceTimer = setTimeout(() => {
                        const selectedContainer = document.getElementById('research-selected');
                        const selectedCount = selectedContainer.querySelectorAll('.btn').length;
            
                        if (selectedCount < 25) {
                            fetchResearchIdeas(query);
                        } else {
                            console.log('too many');
                            const resultsContainer = document.getElementById('research-search-results');
                            resultsContainer.innerHTML = '<p>You have already selected 25 research interests.</p>';
                        }
                    }, 300); // Adding a debounce to reduce the number of requests
                } else {
                    // Clear the results if the query is less than 3 characters
                    document.getElementById('research-search-results').innerHTML = '';
                }
            });
            
            function fetchResearchIdeas(query) {
                const data = new FormData();
                data.append('action', 'ajax_search_research');
                data.append('security_nonce_research', document.getElementById('security_nonce_research').value);
                data.append('keyword', query);
            
                // Exclude already added items
                const selectedIds = Array.from(document.querySelectorAll('#research-selected .btn')).map(div => div.getAttribute('data-value'));                
                data.append('exclude_ids', JSON.stringify(selectedIds));
            
                fetch(ajaxUrlInput, {
                    method: 'POST',
                    body: data
                })
                .then(response => response.json())
                .then(data => {
                    const resultsContainer = document.getElementById('research-search-results');
                    resultsContainer.innerHTML = '';
            
                    if (data.success) {
                        data.data.forEach(item => {
                            if (!selectedIds.includes(item.id)) { // Ensure the item isn't already selected
                                const checkboxId = `collab_${item.id}`;
                                const div = document.createElement('div');
                                div.innerHTML = `
                                    <input type="checkbox" class="btn-check" id="${checkboxId}" autocomplete="off" value="${item.id}">
                                    <label class="me-2 mb-3 btn text-start" for="${checkboxId}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="${item.tooltip}">
                                        ${item.title}
                                    </label>
                                `;
                                resultsContainer.appendChild(div);
            
                                // Add click event listener to each result
                                div.querySelector('.btn-check').addEventListener('click', function() {
                                    addToSelected(item.id, item.title, item.tooltip);
                                });
                            }
                        });
            
                        // Reinitialize tooltips if needed
                        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                            return new bootstrap.Tooltip(tooltipTriggerEl);
                        });
                    } else {
                        resultsContainer.innerHTML = '<p>No results found.</p>';
                    }
                })
                .catch(error => console.error('Error:', error));
            }

            function addToSelected(id, title, tooltip) {
                const selectedContainer = document.getElementById('research-selected');
                const selectedCheckboxId = `selected_research_${id}`;
            
                // Check the current number of selected items
                const selectedCount = selectedContainer.querySelectorAll('.btn').length;
            
                if (selectedCount >= 25) {
                    alert('You have already selected 25 research interests.');
                    document.getElementById('research_ideas').value = '';
                    document.getElementById('research-search-results').innerHTML = ''; 
                    return;
                }
            
                // Create the div element with the selected research interest
                const div = document.createElement('div');
                div.innerHTML = `
                    <div id="${selectedCheckboxId}" class="btn text-start bg-primary text-white me-2 mt-2" data-value="${id}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="${tooltip}">
                        ${title}
                        <i class="bi bi-x-circle-fill remove-icon" data-id="${id}"></i>
                    </div>
                `;
            
                selectedContainer.appendChild(div);
                const newTooltip = new bootstrap.Tooltip(div.querySelector(`[data-bs-toggle="tooltip"]`));

                // Ensure all tooltips are disposed of before removing the item
                const tooltips = document.querySelectorAll('.tooltip'); // Select all tooltips
                tooltips.forEach(tooltip => {
                    tooltip.remove(); // Remove the tooltip elements from the DOM
                });

                // Remove the item from the search results
                const searchResult = document.getElementById(`collab_${id}`);
                if (searchResult) {
                    searchResult.parentElement.remove(); // Remove the search result from the DOM
                }


                // Add event listener to the remove icon
                div.querySelector('.remove-icon').addEventListener('click', function() {
                    removeSelectedItem(id, title, tooltip, newTooltip);
                });

             
            
                
            }

            function removeSelectedItem(id, title, tooltip, tooltipInstance) {
                // Dispose of the tooltip instance
                if (tooltipInstance) {
                    tooltipInstance.dispose();
                }
            
                // Remove the item from the selected list
                const selectedItem = document.getElementById(`selected_research_${id}`);
                if (selectedItem) {
                    selectedItem.remove();
                }
            
                // Re-add the item back to the search results
                const resultsContainer = document.getElementById('research-search-results');
                const checkboxId = `collab_${id}`;
                const resultDiv = document.createElement('div');
                resultDiv.innerHTML = `
                    <input type="checkbox" class="btn-check" id="${checkboxId}" autocomplete="off" value="${id}">
                    <label class="me-2 mb-3 btn text-start" for="${checkboxId}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="${tooltip}">
                        ${title}
                    </label>
                `;
                resultsContainer.appendChild(resultDiv);
            
                new bootstrap.Tooltip(resultDiv.querySelector(`[data-bs-toggle="tooltip"]`));
            
                resultDiv.querySelector('.btn-check').addEventListener('click', function() {
                    addToSelected(id, title, tooltip);
                });

                document.getElementById('research-search-results').innerHTML = ''; 

            }

        }

        //Step 8
        if (stepNumber === 8) {
            allFieldsValid = true; 
            const profilePictureInput = document.getElementById('profilePictureInput');
        }

        //Step 9
        if (stepNumber === 9) {
            allFieldsValid = true; 
        }


       

        //TESTING SO SET TO TRUE
        allFieldsValid = true;


        nextButton.disabled = !allFieldsValid; 
    }  // verify step end


    //Check two emails are the same
    function confirmEmail(input) {
        const emailInput = document.getElementById('email');
        const confirmEmailInput = document.getElementById('email-confirm');
        const errorDiv = document.getElementById('email-match-error');
        
        if (confirmEmailInput.value.trim() !== "") {
            //console.log('email confirm field has a value');

            if (confirmEmailInput.value !== emailInput.value) {
                emailInput.classList.add('invalid');
                confirmEmailInput.classList.add('invalid');
                errorDiv.classList.remove('d-none');
                //console.log('email addresses do not match');
                return false;

            } else {
                emailInput.classList.remove('invalid'); // Remove class on match
                confirmEmailInput.classList.remove('invalid');
                errorDiv.classList.add('d-none');
                //console.log('email addresses match');
                return true;
            }
        }
    }

    //Check two passwords are the same
    function confirmPassword(input) {
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password-confirm');
        const errorDiv = document.getElementById('password-match-error');
        const weakPasswordErrorDiv = document.getElementById('password-weak-error');
      
        if (confirmPasswordInput.value.trim() !== "") {
          // Check for password match
          if (confirmPasswordInput.value !== passwordInput.value) {
            passwordInput.classList.add('invalid');
            confirmPasswordInput.classList.add('invalid');
            errorDiv.classList.remove('d-none'); // Show mismatch error
            //console.log('PASSWORDS DO NOT MATCH');
            return false;
          } else {
            passwordInput.classList.remove('invalid');
            confirmPasswordInput.classList.remove('invalid');
            errorDiv.classList.add('d-none'); // Hide mismatch error
            //console.log('Passwords match');

            // Check for password strength (assuming first password field)
            const isStrongEnough = checkPasswordStrength(passwordInput.value);
            if (!isStrongEnough) {
              passwordInput.classList.add('invalid');
              weakPasswordErrorDiv.classList.remove('d-none'); // Show weak password error
              //console.log('PASSWORD IS NOT STRONG ENOUGH');
              return false;
            } else {
              weakPasswordErrorDiv.classList.add('d-none'); // Hide weak password error
              //console.log('Passwords is strong enough');
              return true;
            }
          }
        } else {
          // Handle empty confirm password 
          errorDiv.classList.add('d-none'); // Hide initial error message
          weakPasswordErrorDiv.classList.add('d-none'); 
          passwordInput.classList.remove('invalid');
          confirmPasswordInput.classList.remove('invalid');
          return false;
        }
      }
      
    //checks strength of password
    function checkPasswordStrength(password) {
        const minLength = 11; // Minimum password length
        const hasUppercase = /[A-Z]/.test(password);
        const hasLowercase = /[a-z]/.test(password);
        const hasNumber = /\d/.test(password);
        const hasSymbol = /[!@#$%^&*]/.test(password);
        
        return (
            password.length >= minLength &&
            hasUppercase &&
            hasLowercase &&
            hasNumber &&
            hasSymbol
        );
    }

    //Toggle Passwords
    const passwordField = document.getElementById('password');
    const passwordToggleIcon = document.getElementById('password-toggle-icon');
    const passwordConfirmField = document.getElementById('password-confirm');
    const passwordConfirmToggleIcon = document.getElementById('password-confirm-toggle-icon');
    document.getElementById('togglePassword').addEventListener('click', () => {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        passwordToggleIcon.classList.toggle('bi-eye-fill');
        passwordToggleIcon.classList.toggle('bi-eye-slash-fill');
    });
    document.getElementById('togglePasswordConfirm').addEventListener('click', () => {
        const type = passwordConfirmField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirmField.setAttribute('type', type);
        passwordConfirmToggleIcon.classList.toggle('bi-eye-fill');
        passwordConfirmToggleIcon.classList.toggle('bi-eye-slash-fill');
    });

    // Function to update the indices of the remaining organizations after deletion
    function updateOrgIndices() {
        const orgDetailsList = document.querySelectorAll('.aff_org_details:not(.d-none)');
        orgDetailsList.forEach((orgDetails, index) => {
            orgDetails.dataset.orgIndex = index + 1;
            orgDetails.querySelectorAll('input').forEach(input => {
                input.name = input.name.replace(/\d+/, index + 1);
            });
        });
    }
    
    function showAddAnotherOrganisationButton() {
        if (addAnotherOrganisationButton && addAnotherOrganisationButton.classList.contains('d-none')) {
            addAnotherOrganisationButton.classList.remove('d-none');
        }
    }

    //Listen for delete button click 
    document.addEventListener('click', function(event) {
        const deleteButton = event.target.closest('.delete-employer-btn');
        if (deleteButton) {
            const employerDetails = deleteButton.closest('.employer_details');
            if (employerDetails) {
                employerDetails.remove();
                updateOrgIndices(); 
                showAddAnotherOrganisationButton(); 
            }
        }
    });

    profilePictureInput.addEventListener('change', handleProfileImageUpload);
    //profile image preview
    function handleProfileImageUpload(e) {
        const loadingIndicator = document.getElementById('profile-img-loading-indicator');
        const defaultProfilePic = document.getElementById('defaultProfilePic');
        const profilePictureInput = e.target;
      
        if (profilePictureInput.files && profilePictureInput.files[0]) {
          // Show loading indicator
          loadingIndicator.classList.remove('d-none');
      
          const reader = new FileReader();
          reader.onload = function (e) {
            defaultProfilePic.src = e.target.result;
            // Hide loading indicator after successful load
            setTimeout(function() {
                loadingIndicator.classList.add('d-none');
              }, 2000);
          };
          reader.readAsDataURL(profilePictureInput.files[0]);
          console.log(document.getElementById('profilePictureInput').value);
        }
    }
        
    

    //Add another profile link
    const addAnotherProfileLink = document.getElementById('addAnotherProfileLink');
    const maxNumberOfLinks = 10;  // Maximum number of organisations allowed
    addAnotherProfileLink.addEventListener('click', function() {
        const existingLinks = document.querySelectorAll('.profile_link:not(.d-none)');
        const currentCount = existingLinks.length + 1;

        if (currentCount <= maxNumberOfLinks) {
            const initialLink = document.querySelector('.profile_link');
            if (initialLink) {
                const newLink = initialLink.cloneNode(true);
                newLink.classList.add('additional_link');
                newLink.dataset.additionalLink = currentCount;

                //Reset input values
                newLink.querySelectorAll('input[type="text"]').forEach(input => {
                    input.value = ''; 
                });                           

                // Update input names based on counter
                newLink.querySelectorAll('input').forEach(input => {
                    if (input.name.startsWith('profile_link_')) {
                        const originalNameParts = input.name.split('-');
                        input.name = `${originalNameParts[0]}-${currentCount}`;
                    }
                });

                // Insert new organization block before the aff_org_footer
                const profileLinksFooter = document.getElementById('profileLinksFooter');
                if (profileLinksFooter) {
                    profileLinksFooter.parentNode.insertBefore(newLink, profileLinksFooter);
                    // Remove the d-none class from the delete button of the newly added organization
                    const deleteButton = newLink.querySelector('.delete-link-btn');
                    if (deleteButton) {
                        deleteButton.classList.remove('d-none');
                    }
                } else {
                    console.error('Element with ID "profileLinksFooter" not found.');
                }
            } else {
                console.error('Initial Link block not found.');
            }
        } else {
            console.warn('Maximum number of link reached.');
        }

        // Update visibility of "Add Another Organisation" button
        if (currentCount === maxNumberOfLinks) {
            addAnotherProfileLink.classList.add('d-none');
        } else {
            addAnotherProfileLink.classList.remove('d-none');
        }
    });

    

    // Function to update the indices of the remaining Links after deletion
    function updateLinkIndices() {
        const linkDetailsList = document.querySelectorAll('.profile_link:not(.d-none)');
        linkDetailsList.forEach((linkDetails, index) => {
            linkDetails.dataset.orgIndex = index + 1;
            linkDetails.querySelectorAll('input').forEach(input => {
                input.name = input.name.replace(/\d+/, index + 1);
            });
        });
    }

    // Function to show the "Add Another Link" button if hidden due to max limit (when deleting one)
    function showAddAnotherLinkButton() {
        const addAnotherProfileLink = document.getElementById('addAnotherProfileLink');
        if (addAnotherProfileLink && addAnotherProfileLink.classList.contains('d-none')) {
            addAnotherProfileLink.classList.remove('d-none');
        }
    }

    //delete logo upload function
    function handleRemoveUpload(event) {
        const container = event.target.closest('.org_logo_container');
        const previewImage = container.querySelector('.org-logo-file');

        if (previewImage) {
            previewImage.src = '';
            previewImage.classList.add('d-none');
        }
        
        const inputFile = container.querySelector('.org_logo_input');
        
        if (inputFile) {
            inputFile.value = '';
        }
        
        event.target.classList.add('d-none');
        
        const uploadText = container.querySelector('.upload-text');
        if (uploadText) {
            uploadText.classList.remove('d-none');
        }
    }

    //complete
    completeButton.addEventListener('click', function() {

        //show loading icon on complete button and disable it 
        document.getElementById('complete_button_load').classList.remove('d-none');
        completeButton.disabled = true;

        //Check that a signup procees has finished so we know they have a profile draft and user account
        if (!initialRegistrationComplete) {
            alert('An issue has occured with the account registration on step 2');
        } else {
            

            //complete profile fields
            var formData = new FormData();
            formData.append('action', 'signup_profile');
            formData.append('security_nonce', document.getElementById('security_nonce').value);
            formData.append('email', document.getElementById('email').value);
            formData.append('summary', document.getElementById('summary').value);
            formData.append('about', document.getElementById('about').value);
            
            //mentoring
            if (document.getElementById('mentor').checked) {
                formData.append('mentoring', true);
            } else {
                formData.append('mentoring', false);
            }

            //website links
            let profile_links = [];
            // Loop through the fields
            for (let i = 1; i <= 10; i++) {
                let linkNameElement = document.querySelector(`input[name="profile_link_name-${i}"]`);
                let linkUrlElement = document.querySelector(`input[name="profile_link_url-${i}"]`);

                // Check if elements exist
                if (linkNameElement && linkUrlElement) {
                    let linkName = linkNameElement.value.trim();
                    let linkUrl = linkUrlElement.value.trim();

                    // Check if link name is not empty
                    if (linkName !== '' && linkUrl !== '') {
                        // Add the values to the array
                        profile_links.push({
                            key: linkName,
                            value: linkUrl
                        });
                    }
                }
            }
            formData.append('profile_links', JSON.stringify(profile_links));

            //Collab on
            let collab_on = [];
            let collab_on_div = document.getElementById('collab_on');
            let collab_on_selected = collab_on_div.querySelectorAll('input[type="checkbox"]:checked');
            collab_on_selected.forEach(input => {
                collab_on.push(input.value);
            });
            formData.append('collab_on', JSON.stringify(collab_on));

            //research interests
            let research_interests = [];
            const selectedResearchInterests = document.querySelectorAll('#research-selected [data-value]');
    
            selectedResearchInterests.forEach(item => {
                research_interests.push(item.getAttribute('data-value'));
            });
            formData.append('research_interests', JSON.stringify(research_interests));
            console.log(JSON.stringify(research_interests));

            //language and country
            formData.append('country', document.getElementById('country').value);
            formData.append('language', document.getElementById('language').value);

            //Newsletter
            if (document.getElementById('newsletter').checked) {
                formData.append('newsletter', true);
            } else {
                formData.append('newsletter', false);
            }

            // profile picture
            let profilePictureInput = document.getElementById('profilePictureInput');
            if (profilePictureInput.files && profilePictureInput.files[0]) {
                formData.append('profile_picture', profilePictureInput.files[0]);
            }




            // Send AJAX request using fetchWithProgress
            fetchWithProgress(ajaxUrlInput, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            }, progress => {
                const progressBar = document.querySelector('#action_loading_bar .progress-bar');
                const percentage = Math.round(progress * 100);
                //complete button
                completeButton
                progressBar.style.width = `${percentage}%`;
                progressBar.setAttribute('aria-valuenow', percentage);
            })
            .then(response => response.json())
            .then(response => {
                // Hide loading bar and button icon
                document.getElementById('action_loading_bar').classList.add('d-none');
                document.getElementById('complete_button_load').classList.add('d-none');
                completeButton.disabled = false;
                if (response.success) {
                    console.log('UPDATE PROFILE successful:', response);

                    // Remove 'active' class from all divs with class 'step'
                    steps.forEach(step => {
                        step.classList.remove('active');
                    });
                    // Remove 'd-none' class from the div with class 'complete'
                    completeDiv.classList.remove('d-none');
                    //hide complete and show close
                    completeButton.classList.add('d-none');
                    previousButton.classList.add('d-none');


                } else {
                    console.error('Profile update has failed:', response.data);
                    // document.getElementById('reg_success_msg').classList.add('d-none');
                    // document.getElementById('reg_error_msg').classList.remove('d-none');
                    // document.getElementById('reg_error_msg').textContent = response.data;
                    // initialRegistrationComplete = false;
                    // activateStep(3);
                }
            })
            .catch(error => {
                console.log('profile update failed:', error);
                // document.getElementById('reg_success_msg').classList.add('d-none');
                // document.getElementById('reg_error_msg').classList.remove('d-none');
                // document.getElementById('reg_error_msg').textContent = 'An error occurred during registration.';
            });
        }
    });

    function initialRegistration() {
        // Prepare form data
        var formData = new FormData();
        formData.append('action', 'user_reg');
        formData.append('security_nonce', document.getElementById('security_nonce').value);
        formData.append('firstname', document.getElementById('firstname').value);
        formData.append('lastname', document.getElementById('lastname').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('telephone', document.getElementById('telephone').value);
        formData.append('username', document.getElementById('username').value);
        formData.append('password', document.getElementById('password').value);
        
        //Profile Types
        let profile_types = [];
        //Individual
        if(document.getElementById('type-individual').checked) {
            const checkedOptions = document.querySelectorAll('#type-individual-option input[type="checkbox"]:checked');
            checkedOptions.forEach(option => {
                profile_types.push({ 
                    key: document.getElementById('type-individual').name, 
                    value: {
                        role: option.value,
                        org: ' '
                    }
                });
            });
        }
        //organisation
        if(document.getElementById('type-organisation').checked) {
            profile_types.push({ 
                key: document.getElementById('type-organisation').name, 
                value: {
                    role: document.getElementById('type-organisation-role').value,
                    org: document.getElementById('type-organisation-org').value
                }
            });
        }
        //research
        if(document.getElementById('type-researcher').checked) {
            profile_types.push({ 
                key: document.getElementById('type-researcher').name, 
                value: {
                    role: document.getElementById('type-researcher-role').value,
                    org: document.getElementById('type-researcher-org').value
                }
            });
        }
        //healthcare
        if(document.getElementById('type-health_and_social_care').checked) {
            profile_types.push({ 
                key: document.getElementById('type-health_and_social_care').name, 
                value: {
                    role: document.getElementById('type-health_and_social_care-role').value,
                    org: document.getElementById('type-health_and_social_care-org').value
                }
            });
        }
        //healthcare
        if(document.getElementById('type-industry').checked) {
            profile_types.push({ 
                key: document.getElementById('type-industry').name, 
                value: {
                    role: document.getElementById('type-industry-role').value,
                    org: document.getElementById('type-industry-org').value
                }
            });
        }
        //funder
        if(document.getElementById('type-funder').checked) {
            profile_types.push({ 
                key: document.getElementById('type-funder').name, 
                value: {
                    role: document.getElementById('type-funder-role').value,
                    org: document.getElementById('type-funder-org').value
                }
            });
            // profile_types.push({ key: document.getElementById('type-funder').name, value: document.getElementById('type-funder-role').value });
        }
        console.log(JSON.stringify(profile_types));
        // Add profile types to formData
        formData.append('profile_types', JSON.stringify(profile_types));


        document.getElementById('action_loading_bar').classList.remove('d-none');
        document.getElementById('next_button_load').classList.remove('d-none');

        // Send AJAX request using fetchWithProgress
        fetchWithProgress(ajaxUrlInput, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        }, progress => {
            const progressBar = document.querySelector('#action_loading_bar .progress-bar');
            const percentage = Math.round(progress * 100);
            progressBar.style.width = `${percentage}%`;
            progressBar.setAttribute('aria-valuenow', percentage);
        })
        .then(response => response.json())
        .then(response => {
            // Hide loading bar and button icon
            document.getElementById('action_loading_bar').classList.add('d-none');
            document.getElementById('next_button_load').classList.add('d-none');
            if (response.success) {
                console.log('Registration successful:', response);
                initialRegistrationComplete = true;
                form.querySelector(`.step[data-step-number="4"]`).classList.remove('d-none');
                document.getElementById('reg_success_msg').classList.remove('d-none');
                document.getElementById('reg_error_msg').classList.add('d-none');
                disable_account_fields();
            } else {
                console.error('Registration failed:', response.data);
                document.getElementById('reg_success_msg').classList.add('d-none');
                document.getElementById('reg_error_msg').classList.remove('d-none');
                document.getElementById('reg_error_msg').textContent = response.data;
                initialRegistrationComplete = false;
                activateStep(3);
            }
        })
        .catch(error => {
            console.log('Registration failed:', error);
            document.getElementById('reg_success_msg').classList.add('d-none');
            document.getElementById('reg_error_msg').classList.remove('d-none');
            document.getElementById('reg_error_msg').textContent = 'An error occurred during registration.';
        });
    }




}); //Dom loaded end


//word counter for input fields
function countWords(input) {
    const text = input.value.trim();
    const words = text.split(/\s+/);
    const wordLimit = parseInt(input.dataset.wordLimit) || 50;
    const badge = document.getElementById(`word-count-${input.id}`); 
  
    if (text === '') {
        badge.textContent = ''; // Clear badge content if input field is empty
    } else {
        badge.textContent = `${words.length}/${wordLimit}`;
    }

    badge.classList.remove('text-bg-danger'); 
  
    if (words.length <= wordLimit) {
      badge.classList.add('text-bg-secondary'); 
    } else {
      badge.classList.add('text-bg-danger'); 
      input.value = text.slice(0, text.split(/\s+/, wordLimit).join(' ').length);
    }

}

//Get progress of a fetch function
function fetchWithProgress(url, options, onProgress) {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open(options.method || 'GET', url);

        // Set headers
        if (options.headers) {
            Object.keys(options.headers).forEach(key => {
                xhr.setRequestHeader(key, options.headers[key]);
            });
        }

        // Set up progress event listener
        xhr.upload.onprogress = (event) => {
            if (event.lengthComputable && onProgress) {
                onProgress(event.loaded / event.total);
            }
        };

        // Set up load event listener
        xhr.onload = () => {
            resolve({
                ok: xhr.status >= 200 && xhr.status < 300,
                status: xhr.status,
                json: () => Promise.resolve(JSON.parse(xhr.responseText)),
                text: () => Promise.resolve(xhr.responseText)
            });
        };

        // Set up error event listener
        xhr.onerror = () => reject(xhr.statusText);

        // Send request
        xhr.send(options.body);
    });
}

//disable account fields 
function disable_account_fields() {
    const fieldIds = [
        'firstname',
        'lastname',
        'email',
        'email-confirm',
        'telephone',
        'username',
        'password',
        'password-confirm'
    ];

    fieldIds.forEach(id => {
        const field = document.getElementById(id);
        if (field) {
            field.disabled = true;
        }
    });

    //message display
    document.getElementById('reg_already_done_msg').classList.remove('d-none');


}


//toggle help on mobile
document.getElementById('toggle_help').addEventListener('click', function() {
    var infoPanel = document.getElementById('info_panel');
    if (infoPanel.classList.contains('d-none')) {
        infoPanel.classList.remove('d-none');
    } else {
        infoPanel.classList.add('d-none');
    }
});

document.getElementById('toggle_help_close').addEventListener('click', function() {
    var infoPanel = document.getElementById('info_panel');
    infoPanel.classList.add('d-none');
});