function markersVisibility(visible)
{
    for (i = 0; i < window.markers.length; i++)
    {
        if (visible == true) {
            window.markers[i].setVisible(true);
        } else {
            window.markers[i].setVisible(false);
        }
    }
}

function toggleGreen()
{
    var checkbox = document.getElementById("poi-Green");
    for (i = 0; i < window.markers.length; i++)
    {
        if (window.markers[i].status === "green")
        {
            if (checkbox.checked == true)
                window.markers[i].setVisible(true);
            else
                window.markers[i].setVisible(false);
        }
    }
}

function toggleYellow()
{
    var checkbox = document.getElementById("poi-Yellow");
    for (i = 0; i < window.markers.length; i++)
    {
        if (window.markers[i].status === "yellow")
        {
            if (checkbox.checked == true)
                window.markers[i].setVisible(true);
            else
                window.markers[i].setVisible(false);
        }
    }
}

function toggleRed()
{
    var checkbox = document.getElementById("poi-Red");
    for (i = 0; i < window.markers.length; i++)
    {
        if (window.markers[i].status === "red")
        {
            if (checkbox.checked == true)
                window.markers[i].setVisible(true);
            else
                window.markers[i].setVisible(false);
        }
    }
}