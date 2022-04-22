//Nav Bar On Scroll
let langList = document.querySelector(".navv .lang-list");
let langIcon = document.querySelector(".navv .lang");

langIcon.onclick = function () {
  if (langList.style.display == "block") {
    langList.style.display = "none";
  } else {
    langList.style.display = "block";
  }
};

document.querySelector(".fixed-side .closee").onclick = function () {
  document.querySelector(".fixed-side").style.right = "-140px";
  document.querySelector(".small-list").style.right = "5px";
};
document.querySelector(".fixed-side .to-top").onclick = function () {
  window.scrollTo(0, 0);
};
document.querySelector(".small-list .to-top-2").onclick = function () {
  window.scrollTo(0, 0);
};
document.querySelector(".small-list .openn").onclick = function () {
  document.querySelector(".fixed-side").style.right = "40px";
  document.querySelector(".small-list").style.right = "-150px";
};

//Responsive Nav
document.querySelector(".res-navv .search input").onfocus = function () {
  document.querySelector(".res-navv .search i").style.right = "40px";
};
document.querySelector(".res-navv .search input").onblur = function () {
  document.querySelector(".res-navv .search i").style.right = "10px";
};
document.querySelector(".res-navv .menu i").onclick = () => {
  document.querySelector(".res-navv .overlay").style.display = "block";
  document.querySelector(".res-navv .toggle-menu").style.left = 0;
};
document.querySelector(".res-navv .overlay").onclick = () => {
  document.querySelector(".res-navv .overlay").style.display = "none";
  document.querySelector(".res-navv .toggle-menu").style.left = "-355px";
};

//Side Bar On Scroll
window.onscroll = function () {
  if (this.scrollY >= 89.6) {
    document.querySelector(".fixed-navv").style.display = "block";
  }
  if (this.scrollY < 89.6) {
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
  if (this.scrollY >= 30) {
    document.querySelector(".res-navv").style.position = "fixed";
  }
  if (this.scrollY < 60) {
    document.querySelector(".res-navv").style.position = "unset";
  }
};

//Mahmoud Part

// بسم الله الرحمن الرحيم
// جعل جميع الصور غير قابله للسحب
let imgArr = Array.from(document.images);
imgArr.forEach((element) => {
  element.setAttribute("draggable", "false");
});

// ---> popup------

// let quickView = document.querySelectorAll(".quick-view");

// let popupBody = document.createElement("div");

// let popupContainer = `
//       <div class="parent-cont">
//         <span id="exit"><i class="fa-solid fa-xmark"></i></span>
//         <div class="popup-containre">
//           <div class="view">
//             <div class="imageToShow">
//               <img
//                 src="./images/home/homeApp-product-app-2-3_1345d6f.webp"
//                 alt="product image"
//               />
//             </div>
//             <div class="slide-show">
//               <i class="fa-solid fa-angle-right right"></i>
//               <i class="fa-solid fa-angle-right left"></i>
//               <div class="image-slide">
//                 </div>
//             </div>
//           </div>
//           <div class="product-data">
//             <h1 id="proName">Giother Laptop Nodels Coped Permi Unde Ona</h1>
//             <div class="pro-target">
//               <div class="stars-cont">
//                 <div class="stars">
//                   <i class="fa-solid fa-star"></i>
//                   <i class="fa-solid fa-star"></i>
//                   <i class="fa-solid fa-star"></i>
//                   <i class="fa-solid fa-star"></i>
//                   <i class="fa-solid fa-star"></i>
//                 </div>
//                 <span>
//                   <span class="viewNumber">2</span>
//                   reviews
//                 </span>
//               </div>
//               <div class="soldNumber">
//                 <i class="fa-solid fa-fire"></i>
//                 sold <span>3</span> times in last <span>10</span> hours
//               </div>
//             </div>
//             <ul class="pro-deatails">
//               <li>Brand: <strong class="brand">Ella - Halothemes</strong></li>
//               <li>Product Code: <strong class="code">KJSU-58836</strong></li>
//               <li>
//                 Availability: <strong class="availability">10</strong>
//                 <strong>In stock</strong>
//               </li>

//               <li><strong class="price">100$</strong></li>
//               <li>
//                 <strong class="description"
//                   >At vero eos et accusamus et iusto odio dignissimos ducimus
//                   qui blanditiis praesentium voluptatum delen</strong
//                 >
//               </li>
//             </ul>
//             <div class="pro-size">
//               <header>
//                 <span>size: <strong id="size">XL</strong></span>
//                 <div class="size-guide">
//                   <i class="fa-solid fa-ruler"></i>
//                   size guide
//                 </div>
//               </header>
//               <ul class="sizeOption">
//                 <li>xs</li>
//                 <li>s</li>
//                 <li>m</li>
//                 <li>l</li>
//                 <li>xl</li>
//               </ul>
//             </div>
//             <div class="pro-color">
//               <span>color: <strong class="color">black</strong></span>
//               <div class="switch-bullets">
//                 <span class="black"></span>
//                 <span class="biege"></span>
//                 <span class="slategray"></span>
//                 <span class="sandybrown"></span>
//               </div>
//             </div>
//             <div class="quantity">
//               <h4>quantity</h4>
//               <div class="quantity-box">
//                 <div class="minuse">-</div>
//                 <div class="number">1</div>
//                 <div class="pluse">+</div>
//               </div>
//             </div>
//             <div class="shopingIt">
//               <button>add to cart</button>
//               <i class="fa-regular fa-heart"></i>
//               <div class="share"><i class="fa-solid fa-share-nodes"></i></div>
//             </div>
//             <div class="randomView">
//               <i class="fa-solid fa-eye"></i>
//               <strong id="randomView">193</strong> customers are viewing this
//               product
//             </div>
//           </div>
//         </div>
//       </div>`;
// popupBody.className = "popupBody";
// popupBody.innerHTML = popupContainer;

// quickView.forEach((Btn) => {
//   Btn.addEventListener("click", (e) => {
//     e.preventDefault();
//     document.body.append(popupBody);
//     popupBody.style.display = "block";
//     //  =====> popup-data <<====== الحصول على محتويات النافذه المنبثقه بشكل داينمك

//     spechialBox = Btn.parentElement.parentElement;
//     let imgToViewInPopup = document.querySelector(
//       ".popup-containre .imageToShow img"
//     );
//     imgToViewInPopup.src = spechialBox.querySelector("img.black").src;

//     let imageSlide = document.querySelector(".popupBody .image-slide ");
//     let imageSlideInSpecial = spechialBox.querySelectorAll("a.images img");
//     imageSlide.innerHTML = "";
//     for (let i = 0; i < imageSlideInSpecial.length; i++) {
//       imageSlide.innerHTML += imageSlideInSpecial[i].outerHTML;
//     }
//     imageSlide.querySelectorAll("img").forEach((img) => {
//       img.addEventListener("click", () => {
//         imgToViewInPopup.src = img.src;
//       });
//     });
//     let proName = document.getElementById("proName");
//     proName.innerHTML = spechialBox.querySelector(".pro_tittle").innerHTML;
//     // ------
//     let stars = document.querySelector(".popupBody .stars");
//     stars.innerHTML = spechialBox.querySelector(".stars").innerHTML;
//     // ----random review---
//     document.querySelector(".popupBody .viewNumber").innerHTML = Math.ceil(
//       Math.random() * 70
//     );
//     // -------randum viewr---
//     document.querySelector("#randomView").innerHTML = Math.ceil(
//       Math.random() * 600
//     );
//     // --------randum sale----
//     document.querySelector(".popupBody .soldNumber span").innerHTML = Math.ceil(
//       Math.random() * 100
//     );
//     document.querySelectorAll(".popupBody .soldNumber span")[1].innerHTML =
//       Math.ceil(Math.random() * 24);

//     document.querySelector(".popupBody .pro-deatails .availability").innerHTML =
//       Math.ceil(Math.random() * 60);
//     // -----price----
//     document.querySelector(".popupBody .pro-deatails .price").innerHTML =
//       spechialBox.querySelector(".price").innerHTML;
//     // ----------sizeOption ---------

//     let sizeOptions = document.querySelectorAll(".popupBody .sizeOption li");
//     sizeOptions.forEach((sizeOption) => {
//       sizeOption.addEventListener("click", () => {
//         document.getElementById("size").innerHTML = sizeOption.innerHTML;
//         document.querySelector(".popupBody .pro-deatails .price").innerHTML =
//           Math.ceil(Math.random() * 150) + "$";
//         sizeOptions.forEach((sizeOption) => {
//           sizeOption.classList.remove("selected");
//         });
//         sizeOption.classList.add("selected");




//       });
//     });
//     // ----------switch-Color  ---------
//     let switchBullets = document.querySelectorAll(
//       ".popupBody .switch-bullets span"
//     );

//     switchBullets.forEach((span) => {
//       span.addEventListener("click", () => {
//         document.querySelector(".popupBody .selescted_color").innerHTML =
//           span.className;
//         document.querySelector(".popupBody .image-slide");
//         imgToViewInPopup.src = document.querySelector(
//           `.popupBody .image-slide .${span.className}`
//         ).src;
//         document.querySelector(".popupBody .color").innerHTML = span.className;
//       });
//     });
//     // ----- quantity ===>
//     let quantity_box = document.querySelector(".popupBody .quantity-box");
//     let quantity_boxNumber = quantity_box.querySelector(".number");

//     quantity_box.querySelector(".pluse").addEventListener("click", () => {
//       quantity_boxNumber.innerHTML++;
//     });
//     quantity_box.querySelector(".minuse").addEventListener("click", () => {
//       if (+quantity_boxNumber.innerHTML > 1) {
//         quantity_boxNumber.innerHTML--;
//       }
//     });
//     // =======shopingIt-------
//     document
//       .querySelector(".popupBody .shopingIt i")
//       .addEventListener("click", () => {
//         document
//           .querySelector(".popupBody .shopingIt i")
//           .classList.toggle("love");
//       });

//     // ----<= exitBtn =>----
//     let exitBtn = document.getElementById("exit");
//     exitBtn.addEventListener("click", () => {
//       popupBody.style.display = "none";
//     });
//   });
// });
// ----------

// add love button
let likeBtns = document.querySelectorAll(".select-option > i");
likeBtns.forEach((btn) => {
  btn.addEventListener("click", function () {
    btn.classList.toggle("love");
  });
});

// choose color ----=>

let colorOptions = document.querySelectorAll(".special_box .switch-bullets >span");

colorOptions.forEach((bullets) => {
  bullets.addEventListener("click", () => {
    bullets.parentElement.parentElement
      .querySelectorAll("img")
      .forEach((img) => {
        img.style.opacity = "0";
      });
    let imgView = bullets.parentElement.parentElement.querySelector(
      `.${bullets.className}`
    );
    imgView.style.opacity = "1";
    let selescted_color =
      bullets.parentElement.parentElement.querySelector(".selescted_color");
    selescted_color.innerHTML = bullets.className;
  });
});

// ----------

//TEST
var swiper = new Swiper(".mySwiper", {
  slidesPerView: 5,
  spaceBetween: 30,
  loop: true,
  slidesPerGroup: 1,
  autoplay: {
    delay: 4000,
    disableOnInteraction: false,
  },
  pagination: {
    el: '.swiper-pagination',
  },
  breakpoints: {
    0: { slidesPerView: 1 },
    550: { slidesPerView: 2 },
    800: { slidesPerView: 3 },
    1000: { slidesPerView: 4 },
    1300: { slidesPerView: 5 },
  },
});

var swipeer = new Swiper(".mySwipeer", {
  slidesPerView: 5,
  spaceBetween: 30,
  loop: true,
  slidesPerGroup: 1,
  autoplay: {
    delay: 8000,
    disableOnInteraction: false,
  },
  pagination: {
    el: '.swiper-pagination',
  },
  breakpoints: {
    0: { slidesPerView: 1 },
    450: { slidesPerView: 2 },
    650: { slidesPerView: 3 },
    900: { slidesPerView: 2 },
    1000: { slidesPerView: 3 },
  },
});

var swiperr = new Swiper(".mySwiperr", {
  slidesPerView: 5,
  spaceBetween: 30,
  loop: true,
  slidesPerGroup: 1,
  autoplay: {
    delay: 7000,
    disableOnInteraction: false,
  },
  pagination: {
    el: '.swiper-pagination',
  },
  breakpoints: {
    0: { slidesPerView: 1 },
    335: { slidesPerView: 2 },
    520: { slidesPerView: 3 },
    720: { slidesPerView: 4 },
    900: { slidesPerView: 5 },
    1150: { slidesPerView: 6 },
    1350: { slidesPerView: 7 },
  },
});



//Test
let selectOption = document.querySelectorAll(".quick-view");
let popup = document.querySelector('.popupBody');
let popupContainer = document.querySelector('.popupBody .parent-cont');
let popupExit = document.querySelector('.popupBody #exit');

selectOption.forEach((btn) => {
  btn.addEventListener('click', (e) => {
    e.preventDefault();
    popup.querySelector('#proName').innerText = e.target.parentElement.parentElement.querySelector('.pro_tittle').innerText;
    popup.querySelector('.stars').innerHTML = e.target.parentElement.parentElement.querySelector('.stars').innerHTML;
    popup.querySelector('.price').innerText = e.target.parentElement.parentElement.querySelector('.price strong').innerText;

    spechialBox = btn.parentElement.parentElement;
    let imgToViewInPopup = document.querySelector(
      ".popup-containre .imageToShow img"
    );
    imgToViewInPopup.src = spechialBox.querySelector("img.black").src;

    let imageSlide = document.querySelector(".popupBody .image-slide ");
    let imageSlideInSpecial = spechialBox.querySelectorAll("a.images img");
    imageSlide.innerHTML = "";
    for (let i = 0; i < imageSlideInSpecial.length; i++) {
      imageSlide.innerHTML += imageSlideInSpecial[i].outerHTML;
    }
    imageSlide.querySelectorAll("img").forEach((img) => {
      img.addEventListener("click", () => {
        imgToViewInPopup.src = img.src;
      });
    });

    //  ----random review---
    document.querySelector(".popupBody .viewNumber").innerHTML = Math.ceil(
      Math.random() * 70
    );
    // -------randum viewr---
    document.querySelector("#randomView").innerHTML = Math.ceil(
      Math.random() * 600
    );
    // --------randum sale----
    document.querySelector(".popupBody .soldNumber span").innerHTML = Math.ceil(
      Math.random() * 100
    );
    document.querySelectorAll(".popupBody .soldNumber span")[1].innerHTML =
      Math.ceil(Math.random() * 24);

    document.querySelector(".popupBody .pro-deatails .availability").innerHTML =
      Math.ceil(Math.random() * 60);


    popup.style.display = "block";
    popupContainer.style.display = "block";
  })
});
let sizeOptions = document.querySelectorAll(".popupBody .sizeOption li");
sizeOptions.forEach((sizeOption) => {
  sizeOption.addEventListener("click", () => {
    document.getElementById("size").innerHTML = sizeOption.innerHTML;
    sizeOptions.forEach((sizeOption) => {
      sizeOption.classList.remove("selected");
    });
    sizeOption.classList.add("selected");
  })
})

// ----- quantity ===>
let quantity_box = document.querySelector(".popupBody .quantity-box");
let quantity_boxNumber = quantity_box.querySelector(".number");

quantity_box.querySelector(".pluse").addEventListener("click", () => {
  quantity_boxNumber.innerHTML++;
});
quantity_box.querySelector(".minuse").addEventListener("click", () => {
  if (+quantity_boxNumber.innerHTML > 1) {
    quantity_boxNumber.innerHTML--;
  }
});
// =======shopingIt-------
document
  .querySelector(".popupBody .shopingIt i")
  .addEventListener("click", () => {
    document
      .querySelector(".popupBody .shopingIt i")
      .classList.toggle("love");
  });

// =======colors-------

document.querySelectorAll('.popupBody .switch-bullets span').forEach((bullet) => {
  bullet.addEventListener("click" , (e) => {
    document.querySelectorAll('.popupBody .image-slide img').forEach((img) => {
      if (img.classList.contains(e.target.className)) {
        document.querySelector('.popupBody .imageToShow img').setAttribute('src' , img.getAttribute("src") )
      }
    })
  })
})

//Exit

popupContainer.addEventListener('click' , (e) => {
  e.stopPropagation();
})
popup.addEventListener('click' , (e) => {
  popup.style.display = "none";
  popupContainer.style.display = "none";
})


popupExit.onclick = () => {
  popup.style.display = "none";
  popupContainer.style.display = "none";
}
