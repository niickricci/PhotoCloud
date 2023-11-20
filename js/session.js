function createTimeoutPopup() {
    $('body').append(`
        <div class='popup'> 
            <div class='popupContent'>
                <div>
                    <div class='popupHearder'> Attention!</div> 
                    <h4 id='popUpMessage'></h4>
                </div>
                <div onclick='closePopup()' class='close-btn fa fa-close'></div> 
            </div>
           
        </div> 
    `);
}
function timeout(timeLeft) {
    createTimeoutPopup();
    let timeBeforeRedirect = 5;

    setInterval(() => {
        timeLeft = timeLeft - 1;
        if (timeLeft > 0) {
            if (timeLeft <= 10) {
                $(".popup").show();
                $("#popUpMessage").text("Expiration dans " + timeLeft + " secondes");
            }
        } else {
            $("#popUpMessage").text('Redirection dans ' + (timeBeforeRedirect + timeLeft) + " secondes");
            if (timeLeft <= -timeBeforeRedirect)
                window.location.reload();
        }
    }, 1000);
}
function closePopup() {
    $(".popup").hide();
    window.location.reload();
} 