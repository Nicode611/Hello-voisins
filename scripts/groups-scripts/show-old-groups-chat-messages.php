<?php

    $includeFile = "../config/db/db.php";
    if (file_exists($includeFile)) { include($includeFile); } else { echo "Le fichier $includeFile n'a pas été trouvé."; }

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $query = "SELECT * FROM groups_chat_messages WHERE group_id = $groupId";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $senderId = $row["sender_id"];
            $message = $row["message"];

            $query2 = "SELECT first_name, profile_img_path FROM users WHERE id = $senderId";
            $result2 = $conn->query($query2);

            if ($result->num_rows > 0) {
                while ($row2 = $result2->fetch_assoc()) {

                    $senderFirstName = $row2["first_name"];
                    $senderProfileImgPath = $row2["profile_img_path"];
                }
            }

            ?>
            
                <div class="received-message-container">
                    <img class="other-users-img" src="../<?php echo $senderProfileImgPath; ?>" alt="">
                    <p class="other-users-id hide"><?php echo $senderId; ?></p>
                    <div class="received-message">
                        <span class="received-message-username"><?php echo $senderFirstName; ?></span>
                        <p class="received-message-content"><?php echo $message; ?></p>
                    </div>
                </div>
            
            <?php
        }
    }








?>