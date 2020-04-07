function printContent() {
    // getting original content of the page
    let originalContents = document.body.innerHTML;
    // getting a content to print
    let printContent = document.getElementById('main').innerHTML;
    // replacing original content with the printable one
    document.body.innerHTML = printContent;
    // printing
    window.print();
    // returning original content to where it was
    document.body.innerHTML = originalContents;
}