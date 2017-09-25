<html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="TikTik">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

    <link rel = "stylesheet" href = "http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="views/pages/ticket/styles.css">
</head>
<body>
<div id="container">
    <h2> Send Hub Ticket </h2>
    <div class="container form-signin">
        <form class="form-signin" action="" method="post" autocomplete="on">

            <input class="form-control" type="text" name="cc" placeholder="Carbon Copy (CC)" value="<?= $this->model->email_cc ?>"/><br />
            <select class="form-control" name="customer" width="">
                <?php
                for($i=0; $i < count($this->model->customerArr); $i++){
                    echo "<option value=\"".$this->model->customerArr[$i]."\">";
                    echo $this->model->customerArr[$i];
                    echo "</option>";
                }
                ?>
            </select><br />

            <input class="form-control" type="text" name="market" placeholder="Market" value="<?= $this->model->market ?>" required/><br />
            <input class="form-control" type="text" name="loc" placeholder="Location" value="<?= $this->model->loc ?>" required/><br />
            <input class="form-control" type="text" name="job" placeholder="Work being performed" value="<?= $this->model->job ?>" required/><br />

            <input class="form-control" type="number" pattern="[0-9]*" mode="numeric" name="hub_id" placeholder="<?= $this->model->hub_id; ?>" value="<?= $this->model->hub_id; ?>" required autofocus/><br />

            <input class="form-control" type="time" name="start_time" style="width:200px;" value="<?= $this->model->start_time ?>"/><br />

            <input class="form-control" type="text" name="tech" placeholder="List team members"value="<?= $this->model->tech ?>" required/><br />

            <input class="form-control" type="text" name="xoc" placeholder="XOC" value="<?= $this->model->xoc ?>"/><br />

            <button class="btn btn-lg btn-primary btn-block" style="width:100%;background-color:yellow;bborder-color:yellow;color:black;" type="submit" name="submit">Submit</button></button>
            <br />
            <button class="btn btn-lg btn-primary btn-block" style="width:100%;background-color:yellow;bborder-color:yellow;color:black;" type="submit" name="delCookies">Clear Memory</button></button>
        </form>
    </div>
    <div id="footer">
        <label id="navid">Copyright &copy Navid Fanaian</label>
    </div>
</div>
</body>
</html>