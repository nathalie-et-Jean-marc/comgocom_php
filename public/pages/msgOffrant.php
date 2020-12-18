            <div class="reponse">

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    </br>
                    <label style="font-weight: bold;"><?php echo $infosMsg[0][0]['pseudoOffrant']; ?></label>
                    </br>
                    <textarea rows="4" 
                              cols="50" 
                              name="msg"><?php echo $infosMsg[0][0]['msg']; ?></textarea>             
                    </br>
                    <input hidden type="text" name="idOffre" value="<?php echo $infosMsg[0][0]['idOffre']; ?>">
                    <input hidden type="text" name="pseudo" value="<?php echo $infosMsg[0][0]['pseudo']; ?>">
                    <input hidden type="text" name="pseudoOffrant" value="<?php echo $infosMsg[0][0]['pseudoOffrant']; ?>">
                    <input class="button" type="submit" value="Poster"  >
                </form>
            </div>

