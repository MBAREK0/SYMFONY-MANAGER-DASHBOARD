function data() {

    return {

        isSideMenuOpen: false,
        toggleSideMenu() {
            this.isSideMenuOpen = !this.isSideMenuOpen
        },
        closeSideMenu() {
            this.isSideMenuOpen = false
        },
        isNotificationsMenuOpen: false,
        toggleNotificationsMenu() {
            this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen
        },
        closeNotificationsMenu() {
            this.isNotificationsMenuOpen = false
        },
        isProfileMenuOpen: false,
        toggleProfileMenu() {
            this.isProfileMenuOpen = !this.isProfileMenuOpen
        },
        closeProfileMenu() {
            this.isProfileMenuOpen = false
        },
        isPagesMenuOpen: false,
        togglePagesMenu() {
            this.isPagesMenuOpen = !this.isPagesMenuOpen
        }

    }
}

function showDeleteConfirmation(event) {
    event.preventDefault();

    // Show the modal
    var modal = document.getElementById('deleteConfirmationModal');
    if (modal) {
        modal.classList.remove('hidden');
    }

    // Retrieve the URL from the event target
    var deleteUrl = event.target.getAttribute('href');
    if (deleteUrl) {
        var confirmDeleteButton = document.getElementById('confirmDeleteButton');
        if (confirmDeleteButton) {
            confirmDeleteButton.setAttribute('href', deleteUrl);
        }
    } else {
        console.error('Delete URL is undefined or missing');
    }
}

