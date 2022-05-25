let y = -10

document.addEventListener('scroll', () => {
    if (window.screen.width > 768) {
        if (y < window.pageYOffset && y > 50) {
            document.querySelector('.navbar').style.top = "-88px"
        } else
            document.querySelector('.navbar').style.top = "0"

        if (document.querySelector('.widget')) {
            if (document.querySelector('.navbar').style.top == '-88px')
                document.querySelector('.widget').style.top = "0"
            else
                document.querySelector('.widget').style.top = "88px"
        }
    } else {
        if (y < window.pageYOffset) {
            document.querySelector('.navbar--mobile').style.bottom = "-88px"
        } else
            document.querySelector('.navbar--mobile').style.bottom = "0"
    }
    y = window.pageYOffset;
})
