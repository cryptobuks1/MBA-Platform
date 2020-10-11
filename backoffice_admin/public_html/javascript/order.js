function print_order_history() {
    var myPrintContent = document.getElementById('print_area');
    var myPrintWindow = window.open("", "Print Order History", 'left=300,top=100,width=700,height=500', '_blank');
    myPrintWindow.document.write(myPrintContent.innerHTML);
    myPrintWindow.document.close();
    myPrintWindow.focus();
    myPrintWindow.print();
    myPrintWindow.close();
    return false;
}