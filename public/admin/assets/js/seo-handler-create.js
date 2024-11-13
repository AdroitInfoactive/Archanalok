let seoTitleEdited = false;
let seoDescriptionEdited = false;

if (level > 0) {
    // Listener for main category changes
    document.getElementById('mainCategorySelect').onchange = function () {
        let category_slug = this.options[this.selectedIndex].getAttribute('data-slug');
        document.getElementById('main-category-slug').value = category_slug;
        document.getElementById('generated-main-category-url').textContent = category_slug;
    };

    // Listener for subcategory changes, only if level is 2
    if (level == 2) {
        document.getElementById('categorySelect').onchange = function () {
            let category_slug = this.options[this.selectedIndex].getAttribute('data-slug');
            document.getElementById('category-slug').value = category_slug;
            document.getElementById('generated-category-url').textContent = category_slug;
        };
    }
}

// Handle input changes for name and update SEO title and slug if not manually edited
document.getElementById('name').addEventListener('input', function () {
    const nameValue = this.value;
    const generatedSlug = generateSlug(nameValue);
    document.getElementById('generated-url-preview').textContent = generatedSlug; // Update preview slug
    document.getElementById('slug').value = generatedSlug; // Update preview slug

    if (!seoTitleEdited) {
        document.getElementById('seo_title').value = nameValue; // Update SEO Title
        document.getElementById('preview-title').textContent = nameValue; // Update preview title
    }
});

// Handle input changes for description and update SEO Description if not manually edited
document.getElementById('description').addEventListener('input', function () {
    const descriptionValue = this.value;

    if (!seoDescriptionEdited) {
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
