<!-- Below code must execute here to avoid FOUC. -->
<script defer>
    // Handle dark mode toggle when the page is loaded.
    if (
        localStorage.theme === "dark" ||
        (!("theme" in localStorage) &&
            window.matchMedia("(prefers-color-scheme: dark)").matches)
    ) {
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
    }

    /**
     * Workaround fix to handle viewport height issue on mobile browsers
     * https://stackoverflow.com/questions/37112218/css3-100vh-not-constant-in-mobile-browser
     */
    const resizeViewportHeight = () => {
        document.documentElement.style.setProperty(
            "--vh",
            window.innerHeight * 0.01 + "px"
        );
    };

    window.addEventListener("resize", resizeViewportHeight);
    resizeViewportHeight();
</script>
