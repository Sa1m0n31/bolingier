let count = 1;
const videoEnd = (e) => {
    if(!e)
    {
        e = window.event;
    }

    if(count === 1) count = 2;
    else count = 1;

    const currentSrc = source.getAttribute('src').split('/');
    currentSrc.pop();
    const srcBeginning = currentSrc.join('/');

    source.setAttribute('src', `${srcBeginning}/video-${count}.mp4`);
    video.load();
    video.play();
}

const video = document.getElementById('mp4Video');
const source = document.getElementById('mp4Source');
video.addEventListener('ended', videoEnd, false);

const nextVideo = () => {
    videoEnd(true);
}

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

const polish = () => {
    window.location = "https://bolingier.skylo-test1.pl";
}

const english = () => {
    window.location = "https://bolingier.skylo-test1.pl/en";
}

const slider1 = new Siema({
    selector: '.homepage__products__main--mobile1',
    perPage: 1,
    draggable: true
});

const slider2 = new Siema({
    selector: '.homepage__products__main--mobile2',
    perPage: 1,
    draggable: true
});

const prevSlider1 = () => {
    slider1.prev();
}

const nextSlider1 = () => {
    slider1.next();
}

const prevSlider2 = () => {
    slider2.prev();
}

const nextSlider2 = () => {
    slider2.next();
}

if(window.innerWidth < 768) {
    const userAgent = navigator.userAgent.toLowerCase();
    if (userAgent .indexOf('safari')!=-1){
        if(userAgent .indexOf('chrome')  > -1){
            //browser is chrome
        }else if((userAgent .indexOf('opera')  > -1)||(userAgent .indexOf('opr')  > -1)){
            //browser is opera
        }else{
            document.querySelector('.topNav__logoWrapper').style.transform = 'translate(-50%, -110%)';
        }
    }
}

let muted = true;

const toggleVideoSound = () => {
    const video = document.querySelector('.video>video');
    const mutedEl = document.querySelector('.muted');
    const unmutedEL = document.querySelector('.unmuted');
    video.muted ^= 1;

    if(muted) {
        mutedEl.style.display = 'none';
        unmutedEL.style.display = 'block';
    }
    else {
        mutedEl.style.display = 'block';
        unmutedEL.style.display = 'none';
    }
    muted = !muted;
}

AOS.init();