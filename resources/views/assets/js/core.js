(function () {
  const root = document.documentElement;
  const savedTheme = localStorage.getItem("scms-theme");

  if (savedTheme) {
    root.setAttribute("data-theme", savedTheme);
  }

  document.addEventListener("click", function (event) {
    const themeButton = event.target.closest("[data-action='toggle-theme']");
    if (themeButton) {
      const current =
        root.getAttribute("data-theme") === "dark" ? "light" : "dark";
      root.setAttribute("data-theme", current === "dark" ? "dark" : "light");
      localStorage.setItem("scms-theme", current);
    }

    const sidebarButton = event.target.closest(
      "[data-action='toggle-sidebar']",
    );
    if (sidebarButton) {
      const sidebar = document.querySelector(".sidebar");
      if (sidebar) {
        sidebar.classList.toggle("collapsed");
      }
    }
  });
})();
