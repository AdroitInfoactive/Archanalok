let seoTitleEdited = false;
let seoDescriptionEdited = false;

if (level > 0) {
    // Listener for main category changes
    document.getElementById('mainCategorySelect').onchange = function () {
        let category_slug = this.options[this.selectedIndex].getAttribute('data-slug');
        document.getElementById('main-category-slug').value = category_slug;
        document.getElementById('generated-main-category-url').textContent = category_slug;
        generate_full_slug();
    };

    // Listener for subcategory changes, only if level is 2
    if (level == 2) {
        document.getElementById('categorySelect').onchange = function () {
            let category_slug = this.options[this.selectedIndex].getAttribute('data-slug');
            document.getElementById('category-slug').value = category_slug;
            document.getElementById('generated-category-url').textContent = category_slug;
            generate_full_slug();
        };
    }
}

document.getElementById('slug').addEventListener('input', function () {
    generate_full_slug();
});

function generate_full_slug() {
    const newSlug = this.value;

    // Check if the slug has changed
    if (newSlug !== originalSlug) {
        document.getElementById('create-url-redirect').style.display = 'block'; // Show checkbox
        document.getElementById('create-url-redirect').checked = true; // Check the checkbox
        document.getElementById('redirect-label').style.display = 'block'; // Show label
        // document.getElementById('generated-url').textContent = newSlug; // Update generated URL

        // Optionally: Add logic to auto-generate a slug from the name input
        const generatedSlug = generateSlug(document.getElementById('slug').value);
        if (generatedSlug) {
            // document.getElementById('slug').value = generatedSlug; // Update the slug input
            document.getElementById('generated-url').textContent = generatedSlug;
            document.getElementById('new-slug').value = generatedSlug;
            if (level === 0) {
                // Level 0: Use only the generated slug without any category prefixes
                full_old_slug = document.getElementById('old-slug').value;
                full_new_slug = generatedSlug;

            } else if (level === 1) {
                let main_category_slug = document.getElementById('main-category-slug').value;
                full_old_slug = main_category_slug + '/' + document.getElementById('old-slug').value;
                full_new_slug = main_category_slug + '/' + generatedSlug;

            } else if (level === 2) {
                let main_category_slug = document.getElementById('main-category-slug').value;
                let category_slug = document.getElementById('category-slug').value;
                full_old_slug = main_category_slug + '/' + category_slug + '/' + document.getElementById('old-slug').value;
                full_new_slug = main_category_slug + '/' + category_slug + '/' + generatedSlug;
            }
            document.getElementById('full-old-slug').value = full_old_slug;
            document.getElementById('full-new-slug').value = full_new_slug;
        }
    } else {
        document.getElementById('create-url-redirect').style.display = 'none'; // Hide checkbox
        document.getElementById('create-url-redirect').checked = false; // Uncheck the checkbox
        document.getElementById('redirect-label').style.display = 'none'; // Hide label
        if (level === 0) {
            // Level 0: Use only the generated slug without any category prefixes
            full_old_slug = document.getElementById('old-slug').value;
            full_new_slug = generatedSlug;

        } else if (level === 1) {
            let main_category_slug = document.getElementById('main-category-slug').value;
            full_old_slug = main_category_slug + '/' + document.getElementById('old-slug').value;
            full_new_slug = main_category_slug + '/' + generatedSlug;

        } else if (level === 2) {
            let main_category_slug = document.getElementById('main-category-slug').value;
            let category_slug = document.getElementById('category-slug').value;
            full_old_slug = main_category_slug + '/' + category_slug + '/' + document.getElementById('old-slug').value;
            full_new_slug = main_category_slug + '/' + category_slug + '/' + generatedSlug;
        }
        document.getElementById('full-old-slug').value = full_old_slug;
        document.getElementById('full-new-slug').value = full_new_slug;
    }
}

// Handle input changes for name and update SEO title and slug if not manually edited
document.getElementById('name').addEventListener('input', function () {
    const nameValue = this.value;
    // Only update SEO Title if it matches the original name
    if (originalSeoTitle === originalName) {
        document.getElementById('seo_title').value = nameValue; // Update SEO Title
        document.getElementById('preview-title').textContent = nameValue; // Update preview title
    }
});

// Handle input changes for description and update SEO Description if not manually edited
document.getElementById('description').addEventListener('input', function () {
    const descriptionValue = this.value;

    // Only update SEO Description if it matches the original description
    if (originalSeoDescription === originalDescription) {
        document.getElementById('seo_description').value = descriptionValue; // Update SEO Description
        document.getElementById('preview-description').textContent =
            descriptionValue; // Update preview description
    }
});

// Set flag when SEO Title is manually edited
document.getElementById('seo_title').addEventListener('input', function () {
    seoTitleEdited = true;
    document.getElementById('preview-title').textContent = this.value;

    // Reset flag if field is empty, so it can auto-update from name again
    if (this.value.trim() === "") {
        seoTitleEdited = false;
        document.getElementById('preview-title').textContent = document.getElementById('name').value;
    }
});

// Set flag when SEO Description is manually edited
document.getElementById('seo_description').addEventListener('input', function () {
    seoDescriptionEdited = true;
    document.getElementById('preview-description').textContent = this.value;

    // Reset flag if field is empty, so it can auto-update from description again
    if (this.value.trim() === "") {
        seoDescriptionEdited = false;
        document.getElementById('preview-description').textContent = document.getElementById(
            'description').value;
    }
});

// Toggle SEO fields visibility
document.getElementById('edit-seo-btn').addEventListener('click', function () {
    const seoFields = document.getElementById('seo-fields');
    seoFields.style.display = seoFields.style.display === 'none' ? 'block' : 'none';
});
