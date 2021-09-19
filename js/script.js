window.onload = function init() {
    "use strict";

    ///// Menu JS /////

    // If the url is menu.php
    // Note: I added this because I don't want my js to try to execute this code on every page, but I wanted to include the js file in the header
    if (document.URL.includes("https://valeriehosler.com/Cupcakery/menu.php")) {
        // Menu "links"
        const berry_menu = document.getElementById("berry-menu");
        const carrot_menu = document.getElementById("carrot-menu");
        const cinnamon_menu = document.getElementById("cinnamon-menu");
        const mint_menu = document.getElementById("mint-menu");
        const rainbow_menu = document.getElementById("rainbow-menu");
        const red_menu = document.getElementById("red-menu");

        // Cupcake divs
        const berry_div = document.getElementById("berry");
        const carrot_div = document.getElementById("carrot");
        const cinnamon_div = document.getElementById("cinnamon");
        const mint_div = document.getElementById("mint");
        const rainbow_div = document.getElementById("rainbow");
        const red_div = document.getElementById("red-velvet");

        const div_arr = [berry_div, carrot_div, cinnamon_div, mint_div, rainbow_div, red_div];

        // Event handlers
        berry_menu.addEventListener("click", () => {
            set_display(div_arr, berry_div);
        });

        carrot_menu.addEventListener("click", () => {
            set_display(div_arr, carrot_div);
        });

        cinnamon_menu.addEventListener("click", () => {
            set_display(div_arr, cinnamon_div);
        });

        mint_menu.addEventListener("click", () => {
            set_display(div_arr, mint_div);
        });

        rainbow_menu.addEventListener("click", () => {
            set_display(div_arr, rainbow_div);
        });

        red_menu.addEventListener("click", () => {
            set_display(div_arr, red_div);
        });
    } // Ends if statement
}; // Ends window.onload

// Sets the cupcake item display on the menu
function set_display(arr, div) {
    for (let i = 0; i < arr.length; i++) {
        if (arr[i].id === div.id) {
            arr[i].style.display = "flex";
        } else {
            arr[i].style.display = "none";
        }
    }
}
