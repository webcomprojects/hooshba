// Function to convert a string to a URL-friendly slug
function stringToSlug(str) {
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
    var to   = "aaaaeeeeiiiioooouuuunc------";
    for (var i=0, l=from.length ; i<l ; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

    return str;
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

// Initialize slug generation only on create forms
document.addEventListener('DOMContentLoaded', function() {
    // Only initialize if we're on a create form
    if (window.location.pathname.includes('/create')) {
        // For posts
        initSlugGenerator('title', 'slug');

        // For pages
        initSlugGenerator('title', 'address');
    }
});