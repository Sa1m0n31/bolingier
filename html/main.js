const showSubmenu = () => {
    const submenu = document.querySelector('.topMenu__submenu');

    submenu.style.zIndex = '3';
    submenu.style.opacity = '1';
}

const hideSubmenu = () => {
    const submenu = document.querySelector('.topMenu__submenu');

    submenu.style.zIndex = '-1';
    submenu.style.opacity = '0';
}
