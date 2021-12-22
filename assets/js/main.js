const showSubmenu = () => {
    const submenu = document.querySelector('.topMenu__submenu');

    submenu.style.zIndex = '9999';
    submenu.style.opacity = '1';
}

const hideSubmenu = () => {
    const submenu = document.querySelector('.topMenu__submenu');

    submenu.style.zIndex = '-1';
    submenu.style.opacity = '0';
}

const openMobileMenu = () => {
    const mobileMenu = document.querySelector('.menuMobile');
    const mobileMenuInner = document.querySelector(".menuMobile__inner");

    mobileMenu.style.transform = "scaleX(1)";
    setTimeout(() => {
        mobileMenuInner.style.opacity = '1';
    }, 300);
}

const closeMobileMenu = () => {
    const mobileMenu = document.querySelector('.menuMobile');
    const mobileMenuInner = document.querySelector(".menuMobile__inner");

    mobileMenuInner.style.opacity = '0';
    setTimeout(() => {
        mobileMenu.style.transform = "scaleX(0)";
    }, 300);
}

const openMobileMenuOnMobile = () => {
    if(window.innerWidth < 768) {
        openMobileMenu();
    }
}