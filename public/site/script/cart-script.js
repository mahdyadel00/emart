//Nav Bar On Scroll
let langList = document.querySelector('.navv .lang-list');
let langIcon = document.querySelector('.navv .lang');

(langIcon).onclick = function () {
    if (langList.style.display == "block") {
        langList.style.display = "none"
    } else {
        langList.style.display = "block"
    }
}

document.querySelector('.fixed-side .closee').onclick = function() {
    document.querySelector('.fixed-side').style.right = "-140px";
    document.querySelector('.small-list').style.right = "5px";
}
document.querySelector('.fixed-side .to-top').onclick = function() {
    window.scrollTo(0 , 0);
}
document.querySelector('.small-list .to-top-2').onclick = function() {
    window.scrollTo(0 , 0);
}
document.querySelector('.small-list .openn').onclick = function () {
    document.querySelector('.fixed-side').style.right = "40px";
    document.querySelector('.small-list').style.right = "-150px";
}

//Responsive Nav
document.querySelector('.res-navv .search input').onfocus = function () {
    document.querySelector('.res-navv .search i').style.right = "40px"
}
document.querySelector('.res-navv .search input').onblur = function () {
    document.querySelector('.res-navv .search i').style.right = "10px"
}
document.querySelector('.res-navv .menu i').onclick = () => {
    document.querySelector('.res-navv .overlay').style.display = "block"
    document.querySelector('.res-navv .toggle-menu').style.left = 0
}
document.querySelector('.res-navv .overlay').onclick = () => {
    document.querySelector('.res-navv .overlay').style.display = "none"
    document.querySelector('.res-navv .toggle-menu').style.left = "-355px"   
}

//Side Bar On Scroll
window.onscroll = function() {
    if (this.scrollY >= 89.6) {
        document.querySelector(".fixed-navv").style.display = "block";
    }
    if (this.scrollY < 89.6){
        document.querySelector(".fixed-navv").style.display = "none";
    }
    if (this.scrollY >= 170) {
        document.querySelector(".fixed-side .cart").style.height = "50px";
        document.querySelector(".fixed-side .to-top").style.height = "50px";
    }
    if (this.scrollY < 170) {
        document.querySelector(".fixed-side .cart").style.height = "0";
        document.querySelector(".fixed-side .to-top").style.height = "0";
    }
    if(this.scrollY >= 30) {
        document.querySelector('.res-navv').style.position = "fixed"
    }
    if(this.scrollY < 60) {
        document.querySelector('.res-navv').style.position = "unset"
    }
}
