  // JavaScript to check overflow and toggle class
  document.querySelectorAll('.button').forEach(button => {
    const buttonText = button.querySelector('.button-text');
    const buttonIconOnly = button.querySelector('.button-icon-only');

    if (buttonText.scrollWidth > button.clientWidth) {
        button.classList.add('hidden-text');
    } else {
        button.classList.remove('hidden-text');
    }
});
window.addEventListener('scroll', function () {
    const searchBar = document.querySelector('.form');
    const sticky = searchBar.offsetTop;

    if (window.pageYOffset > sticky) {
        searchBar.classList.add('fixed-top');
    } else {
        searchBar.classList.remove('fixed-top');
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const searchButton = document.querySelector('.filters .btn-secondary');
    const searchEmergencySection = document.getElementById('searchEmergency');

    searchButton.addEventListener('click', function () {
        if (searchEmergencySection.style.display === 'none' || !searchEmergencySection.style.display) {
            searchEmergencySection.style.display = 'block';
        } else {
            searchEmergencySection.style.display = 'none';
        }
    });
});
