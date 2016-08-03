<?php

function replyForm(){
    echo "
        <div>
            <form class='' method='post' action=''>
            <fieldset>
                <legend>REPLY</legend>
                    <label>Your Message</label><br>
                    <input name='newMessage' type='text'><br>
                    <button type='submit' name='submit'>SEND</button>
            </fieldset>
            </form>
        </div>
        ";
}



