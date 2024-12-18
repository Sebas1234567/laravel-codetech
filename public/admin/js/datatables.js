$(document).ready(()=>{
    $('.datatable').DataTable({
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'],
        language: {
            url: '/admin/assets/es-MX.json',
        }
    });
    $('.datatable').attr('style','border-collapse: collapse !important');
    $('.datatable').attr('style','border-radius: 8px !important');
});