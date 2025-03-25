<style>
    body {
        height: 80vh;
        overflow: hidden;
    }

    #main-wrapper {
        height: calc(80vh - 60px); /* Adjust for header height */
        overflow: hidden;
    }

    .content-body {
        height: calc(80vh - 120px); /* Adjust for header + menu heights */
        overflow: auto;
        padding: 20px;
    }

    .dataTables_wrapper {
        height: calc(80vh - 180px);
        overflow: hidden;
    }

    .dataTables_scrollBody {
        max-height: calc(80vh - 250px) !important;
    }

    /* Smooth transitions */
    #main-wrapper,
    .content-body,
    .dataTables_wrapper,
    .dataTables_scrollBody {
        transition: height 0.3s ease-in-out;
    }

    @media (max-height: 768px) {
    body {
        height: 85vh;
    }
    
    #main-wrapper {
        height: calc(85vh - 50px);
    }
    
    .content-body {
        height: calc(85vh - 100px);
    }
}

@media (max-height: 576px) {
    body {
        height: 90vh;
    }
    
    #main-wrapper {
        height: calc(90vh - 40px);
    }
    
    .content-body {
        height: calc(90vh - 80px);
    }
}
</style>