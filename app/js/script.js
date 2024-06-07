// Open tab in profile page
function openTab(event, tabName) {
    var tabcontent = document.getElementsByClassName('profile_content');
    for(var i = 0; i < tabcontent.length; i++) {
        tabcontent[i].classList.remove('active');
        console.log('Le contenu n\'est plus actif');
    }
    
    var tablinks = document.querySelectorAll('.profile_menu-link a');
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].classList.remove('active');
    }

    document.getElementById(tabName).classList.add('active');
    
    if(event) {
        event.currentTarget.classList.add('active');
    }
    }

document.addEventListener('DOMContentLoaded', function() {
    var links = document.querySelectorAll('.profile_menu-link a');
    links.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            console.log(this.getAttribute('href'));
            openTab(event, this.dataset.tab);
        });
    });
});