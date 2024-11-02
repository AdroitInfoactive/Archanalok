let isFormChanged = false;
let isSubmitting = false;
let suppressUnloadWarning = false; // Flag to suppress the unload warning

// Track changes in the form fields
const formElements = document.querySelectorAll('input, textarea, select');
formElements.forEach(element => {
    element.addEventListener('change', () => {
        isFormChanged = true;
    });
});

// Capture any form submission across the page
window.addEventListener('submit', (event) => {
    const form = event.target;
    if (form.tagName === 'FORM') {
        isSubmitting = true; // Set flag to indicate form submission
    }
}, true); // Use capturing to ensure it catches before other handlers

// Handle page unload (refresh or navigation away)
window.addEventListener('beforeunload', (event) => {
    if (isFormChanged && !isSubmitting && !suppressUnloadWarning) {
        const confirmationMessage = 'You have unsaved changes. Are you sure you want to leave?';
        event.returnValue = confirmationMessage; // For most browsers
        return confirmationMessage; // For compatibility with some browsers
    }
});

// Clear form fields after the page reload, but skip CSRF token
window.addEventListener('load', () => {
    if (!isEditPage) { // Only clear fields on add page
        formElements.forEach(element => {
            if (element.tagName === 'INPUT' && element.type !== 'checkbox' && element.type !== 'radio' && element.type !== 'hidden') {
                element.value = ''; // Clear text inputs
            } else if (element.tagName === 'TEXTAREA') {
                element.value = ''; // Clear textareas
            } else if (element.tagName === 'SELECT') {
                element.selectedIndex = 0; // Reset selects to the first option
            }
        });
    }
});


// Handle click on links
document.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', (event) => {
        const href = event.target.getAttribute('href');

        // Check if the link is not empty and not a hash
        if (isFormChanged && !isSubmitting && href && href !== '#') {
            event.preventDefault(); // Prevent immediate navigation
            Swal.fire({
                title: 'You have unsaved changes.',
                text: 'Are you sure you want to leave?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, leave',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    suppressUnloadWarning = true; // Set flag to suppress unload warning
                    window.location.href = href; // Proceed with the link
                }
            });
        }
    });
});

// Function to generate URL slug from name
function generateSlug(text) {
    return text
        .toString()
        .toLowerCase()
        .trim()
        .replace(/\s+/g, '-') // Replace spaces with -
        .replace(/[^\w\-]+/g, '') // Remove all non-word chars
        .replace(/\-\-+/g, '-') // Replace multiple - with single -
        .replace(/^-+/, '') // Trim - from start of text
        .replace(/-+$/, ''); // Trim - from end of text
}
