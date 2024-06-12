const change_password_btn = document.getElementById('change_password_btn');
const change_password_form = document.getElementById('change_password_form');

change_password_btn.addEventListener('click', () => {
    let form_style = change_password_form.style.display;
    change_password_form.style.display = form_style === 'none' ? 'block' : 'none';
});
