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

// Confirm Deletion
function confirmDeletion(recipe_id, event, confirmMessage, form) {
    event.preventDefault();

    if (!form || form.trim() === '') {
        console.error('ID du formulaire non valide :', form);
        return;
    }

    if (confirm(confirmMessage)) {
        // Met à jour l'identifiant de la recette dans le formulaire caché
        document.getElementById('recipeId').value = recipe_id;
        // Soumet le formulaire
        document.getElementById(form).submit();
    }
}

function addToFavorite(user_id, recipe_id) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/website_recipe/app/scripts/favorites/favorite_add.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var recipeLikeIcon = document.querySelector('.recipe-like i');
            if (recipeLikeIcon.classList.contains('active')) {
                recipeLikeIcon.classList.remove('fa-regular', 'active');
                recipeLikeIcon.classList.add('fa-solid')
            } else {
                recipeLikeIcon.classList.add('fa-regular', 'active');
                recipeLikeIcon.classList.remove('fa-solid')
            }
        }
    };
    xhr.send("user_id=" + user_id + "&recipe_id=" + recipe_id);
}