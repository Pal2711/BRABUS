document.addEventListener('DOMContentLoaded', function () {
    if (motorsPreloaderSettings.preloaderEnabled) {
        var preloader = document.getElementById('preloader')
        if (preloader) {
            preloader.style.display = 'block'

            if (motorsPreloaderSettings.timeoutEnabled) {
                var timeout = motorsPreloaderSettings.preloaderTimeout * 1000


                setTimeout(function () {
                    preloader.style.display = 'none'
                }, timeout)
            } else {
                window.addEventListener('load', function () {
                    preloader.style.display = 'none'
                })
            }
        }
    } else {
        var preloader = document.getElementById('preloader')
        if (preloader) {
            preloader.style.display = 'none'
        }
    }
})
