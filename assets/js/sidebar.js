$(document).ready(function () {

    var arrowOrientation = function (element) {
        let listId = $(element).attr('href');
        if ($(listId).hasClass("show")) {
            $(element).find(".fa-caret-down").css("transform", "rotateZ(-90deg)");
        } else {
            $(element).find(".fa-caret-down").css("transform", "rotateZ(0deg)");
        }
    };
    $(".attribution-link").click(function () {
        $("#analyticsSubmenu").removeClass("show");
        $("#monetizationSubmenu").removeClass("show");
        $("#reportsSubmenu").removeClass("show");
        arrowOrientation(this);
    });

    $(".analytics-link").click(function () {
        $("#attributionSubmenu").removeClass("show");
        $("#monetizationSubmenu").removeClass("show");
        $("#reportsSubmenu").removeClass("show");
        arrowOrientation(this);
    });
    $(".monetization-link").click(function () {
        $("#attributionSubmenu").removeClass("show");
        $("#analyticsSubmenu").removeClass("show");
        $("#reportsSubmenu").removeClass("show");
        arrowOrientation(this);
    });
    $(".reports-link").click(function () {
        $("#attributionSubmenu").removeClass("show");
        $("#analyticsSubmenu").removeClass("show");
        $("#monetizationSubmenu").removeClass("show");
        arrowOrientation(this);
    });

    var sideNav = function (closeExpandedHover) {
        if (window.innerWidth < 768) {
            document.querySelector("aside.sidenav").classList.add("sidenav-expanded-button");
            document.querySelector(".sidenav-menu .image-container").addEventListener("click", function () {
                document.querySelector(".sidenav").style.left = "-75%";
            });

            document.querySelector(".mobile-navbar-button").addEventListener("click", function () {
                document.querySelector("aside.sidenav").style.left = "0%";
            });
        }

        if (window.innerWidth >= 768) {
            //document.querySelector("aside.sidenav").classList.remove("sidenav-expanded-button");
            var sidenavButton = document.querySelector(".sidenav-menu .image-container");
            if (sidenavButton) {
                sidenavButton.addEventListener("click", function () {
                    setTimeout(function () {
                        $app.graph.resize();
                    }, 1);
                    if (document.querySelector("aside.sidenav").classList.contains("sidenav-expanded-button")) {
                        try {
                            $app.db.setCookie("_sdbar", false);
                            var menuArrows = document.querySelectorAll(".sidenav .fa-caret-down");
                            menuArrows.forEach(function (arrow) {
                                arrow.style.transform = "rotateZ(-90deg)";
                            });
                        } catch (err) {
                            $app.debug(err.message, true);
                        }
                    } else {
                        try {
                            $app.db.setCookie("_sdbar", true);
                        } catch (err) {
                            $app.debug(err.message, true);
                        }
                    }
                    document.querySelector("aside.sidenav").classList.toggle("sidenav-expanded-button");
                    document.querySelector(".main-container").classList.toggle("main-container-expanded-sidenav");
                    if (sidenav.classList.contains("sidenav-expanded-hover")) {
                        document.querySelector("aside.sidenav").addEventListener("mouseleave", closeExpandedHover);
                    } else {
                        document.querySelector("aside.sidenav").removeEventListener("mouseleave", closeExpandedHover);
                    }
                    sidenav.classList.remove("sidenav-expanded-hover");
                    closeExpandedButton();
                });

                var sidenav = document.querySelector("aside.sidenav");
                document.querySelector(".sidenav .sidenav-links-container").addEventListener("mouseover", function () {
                    document.querySelector("aside.sidenav").classList.add("sidenav-expanded-hover");
                });
                document.querySelector("aside.sidenav").addEventListener("mouseleave", closeExpandedHover);
            }

        }
    };

    var closeExpandedHover = function () {
        $("aside.sidenav").removeClass("sidenav-expanded-hover");
        $("aside.sidenav").find(".list-unstyled").removeClass("show");
        $("aside.sidenav").find(".fa-caret-down").css("transform", "rotateZ(-90deg)");
    };

    var closeExpandedButton = function () {
        $("aside.sidenav").find(".list-unstyled").removeClass("show");
    };
    sideNav(closeExpandedHover);

});