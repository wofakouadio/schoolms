<script>
    $(document).ready(()=>{

        // get set theme
        console.log(localStorage.getItem('theme'))

        if(localStorage.getItem('theme') == 'dark'){
            $("body").attr('data-theme-version', 'dark')
            $(".dz-theme-mode").addClass('active')
        }else{
            $("body").attr('data-theme-version', 'light')
            $(".dz-theme-mode").removeClass('active')
        }

        // set dashboard theme
        $(".dz-theme-mode").on("click", ()=>{
            console.log(true)
            if($(".dz-theme-mode").hasClass("active")){
                localStorage.setItem('theme', 'dark')
                $("body").attr('data-theme-version', 'dark')
            }else{
                localStorage.setItem('theme', 'light')
                $("body").attr('data-theme-version', 'light')
            }
        })
    })
</script>
