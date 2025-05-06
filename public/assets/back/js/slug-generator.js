// Function to convert a string to a URL-friendly slug
function stringToSlug(str) {
    titleStr = str.replace(/^\s+|\s+$/g, '');
    titleStr = titleStr.toLowerCase();
   //persian support
    titleStr = titleStr.replace(/[^a-z0-9_\s-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/, '')
    // Collapse whitespace and replace by -
        .replace(/\s+/g, '-')
        // Collapse dashes
        .replace(/-+/g, '-');
    return titleStr;
}

// Function to initialize slug generation for a form
function initSlugGenerator(titleFieldId, slugFieldId) {
    const titleField = document.getElementById(titleFieldId);
    const slugField = document.getElementById(slugFieldId);

    if (titleField && slugField) {
        titleField.addEventListener('input', function() {
            slugField.value = stringToSlug(this.value);
        });
    }
}

// Initialize slug generation for posts
document.addEventListener('DOMContentLoaded', function() {
    // For posts
    initSlugGenerator('title', 'slug');

    // For pages
    initSlugGenerator('title', 'address');
});