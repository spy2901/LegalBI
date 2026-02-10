// Dark-mode utilities: toggle, apply and persist theme choice
(function () {
  var storageKey = "legalbi-theme";

  function applyDarkMode(enabled) {
    var btn = document.querySelector(".dark-mode-toggle");
    if (enabled) {
      document.body.classList.add("dark-mode");
    } else {
      document.body.classList.remove("dark-mode");
    }
    if (btn) {
      var icon = btn.querySelector("i");
      if (icon) {
        icon.classList.remove("fa-moon", "fa-sun");
        icon.classList.add(enabled ? "fa-sun" : "fa-moon");
      }
    }
  }

  function setSavedTheme(enabled) {
    try {
      if (enabled) localStorage.setItem(storageKey, "dark");
      else localStorage.setItem(storageKey, "light");
    } catch (e) {
      // ignore
    }
  }

  function getSavedTheme() {
    try {
      return localStorage.getItem(storageKey);
    } catch (e) {
      return null;
    }
  }

  document.addEventListener("DOMContentLoaded", function () {
    var btn = document.querySelector(".dark-mode-toggle");

    // initial: prefer saved, then system preference
    var saved = getSavedTheme();
    var prefersDark =
      window.matchMedia &&
      window.matchMedia("(prefers-color-scheme: dark)").matches;
    var startDark = saved === "dark" || (saved === null && prefersDark);
    applyDarkMode(startDark);

    if (!btn) return;

    btn.addEventListener("click", function (e) {
      e.preventDefault();
      var isDark = document.body.classList.toggle("dark-mode");
      applyDarkMode(isDark);
      setSavedTheme(isDark);
    });
  });

  // expose for debugging: window.setDarkMode(true/false)
  window.setDarkMode = function (v) {
    applyDarkMode(!!v);
    setSavedTheme(!!v);
  };
})();
