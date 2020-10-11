function initheader() {
    window.addEventListener('scroll', function (e) {
        var distanceY = window.pageYOffset || document.documentElement.scrollTop,
            shrinkOn = 120,
            header = document.querySelector("#topheader");
        body = document.querySelector("body");
        if (distanceY > shrinkOn) {
            classie.add(header, "navbar-fixed-top");
            classie.add(header, "pullDown");
            classie.add(body, "fixed-headered");
        } else {
            if (classie.has(header, "navbar-fixed-top")) {
                classie.remove(header, "navbar-fixed-top");
            }
            if (classie.has(header, "pullDown")) {
                classie.remove(header, "pullDown");
            }
            if (classie.has(body, "fixed-headered")) {
                classie.remove(body, "fixed-headered");
            }

        }
    });
}
window.onload = initheader();