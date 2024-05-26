<?php

function alert_timer($data, $location) {
    echo
    "<script>
        let timerInterval
        Swal.fire({
            icon: 'success',
            text: '".$data."',
            timer: 1000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                window.location='".$location."';
            }
        })
    </script>
    ";
}

function alert($icon, $text, $location){
    echo '
        <script>
            Swal.fire({
                icon: "'.$icon.'",
                text: "'.$text.'",
                showCancelButton: false,
                confirmButtonColor: "#004180",
                cancelButtonColor: "#d33",
                confirmButtonText: "ok"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href="'.$location.'"
                }
            })
        </script>
    ';
}