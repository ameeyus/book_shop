// assets/js/script.js
document.addEventListener('DOMContentLoaded', function () {
    var searchIcon = document.getElementById('search-icon');
    var searchForm = document.querySelector('.search-form');

    searchIcon.addEventListener('click', function () {
        if (searchForm.style.display === 'none' || searchForm.style.display === '') {
            searchForm.style.display = 'block';
        } else {
            searchForm.style.display = 'none';
        }
    });
});
document.querySelector(".toggle_menu").addEventListener("click",()=>{
    document.querySelector("header nav").classList.add("active");
});
document.querySelector("header nav").addEventListener("click",()=>{
    document.querySelector("header nav").classList.remove("active");
});
document.querySelector("header nav ul").addEventListener("click",(event)=>{
    event.stopPropagation();
});

document.querySelector("#popup_message").addEventListener("click", function (){
    this.classList.remove("active");
});




