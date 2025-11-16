import './bootstrap.js';
import './styles/app.css';


/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */


const hamburger=document.querySelector(".toggle-btn");
const toggler=document.querySelector("#icon");
hamburger.addEventListener("click",function(){
    document.querySelector("#sidebar").classList.toggle("expand");
    toggler.classList.toggle("bxs-chevrons-right");
    toggler.classList.toggle("bxs-chevrons-left");

});
 document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const rows = document.querySelectorAll("table tbody tr");

    if (!searchInput || rows.length === 0) return;

    function filterTable() {
        const filter = searchInput.value.toLowerCase();
        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(filter) ? "" : "none";
        });
    }

    // Appliquer le filtre au démarrage (si le champ a déjà une valeur)
    filterTable();

    // Appliquer le filtre à chaque frappe
    searchInput.addEventListener("keyup", filterTable);
});



        document.addEventListener("DOMContentLoaded", function () {
            const tabButtons = document.querySelectorAll(".tab-btn");
            const tabPanes = document.querySelectorAll(".tab-pane");

            tabButtons.forEach(btn => {
                btn.addEventListener("click", function () {
                    // Retirer 'active' de tous les boutons et onglets
                    tabButtons.forEach(b => b.classList.remove("active"));
                    tabPanes.forEach(pane => pane.classList.remove("active"));

                    // Ajouter 'active' au bouton et à l'onglet cible
                    this.classList.add("active");
                    const targetId = this.getAttribute("data-target");
                    document.getElementById(targetId).classList.add("active");
                });
            });
        });