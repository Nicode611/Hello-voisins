<?php
session_start();

$includeFile = "../../config/db/db.php";
if (file_exists($includeFile)) { include($includeFile); } else { echo "Le fichier $includeFile n'a pas été trouvé."; }
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

$selfId = $_SESSION['user_id'];

$sql = "SELECT * FROM groups WHERE JSON_CONTAINS(users_ids, JSON_QUOTE('$selfId')) OR admin_id = $selfId";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $groupName = $row["group_name"];
        $adminId = $row["admin_id"];
        $groupId = $row["id"];
        
        // Convertis la colonne JSON en un tableau PHP
        $groupMembers = json_decode($row["users_ids"]);
        $groupMembersNmbr = count($groupMembers);

        // Convertis le tableau en une chaîne de IDs séparés par des virgules
        $idsString = implode(',', $groupMembers);

        // Ajoute l'id de l'admin a cette chaine
        $idsString = $idsString . ',' . $adminId;
        
        // On crée une variable $html et on y concatene des bouts de html afin de créer le message final
        $html = '
        <div class="group">
            <div class="group-infos-container">
                <div class="group-infos">
                    <h4 id="channelName">' . htmlspecialchars($groupName) . '</h4>';
        // Vérifie si l'utilisateur est admin
        if ($adminId == $selfId) {
            $html .= '<span>Admin</span>';
        }
        $html .= '
                    <img class="group-img" src="../assets/images/user2.jpg" alt="">
                    <div class="number-container">

                        <div class="popup-group-members">';

                        $query = "SELECT first_name, last_name FROM users WHERE id IN ($idsString)";
                        $result2 = $conn->query($query);
                        
                        $query2 = "SELECT * FROM contacts WHERE (added_by_user_id = $selfId OR added_user_id = $selfId) AND (added_by_user_id IN ($idsString) OR added_user_id IN ($idsString))";
                        $result3 = $conn->query($query2);
                        
                        // A MODIFIER
                        while ($user = $result2->fetch_assoc() and $row = $result3->fetch_assoc()) {
                            $html .= '<div class="contact-group-container">
                                            <span>' . htmlspecialchars($user["first_name"] . " " . $user["last_name"]) . '</span>';
                        
                            if ($row["statut"] == 'added') {
                                $html .= '<span> Ajouté </span>';
                            } else if ($row["statut"] == 'waiting') {
                                $html .= '<span> En attente </span>';
                            } else {
                                $html .= '<svg class="add-user-group" fill="#000000" viewBox="0 0 24 24" id="add-user-left-6" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color"><path id="secondary" d="M7,5H3M5,7V3" style="fill: none; stroke: #69E13F; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary" d="M11,3.41A5.11,5.11,0,0,1,13,3a5,5,0,1,1-4.59,7" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary-2" data-name="primary" d="M12,13h2a7,7,0,0,1,7,7v0a1,1,0,0,1-1,1H6a1,1,0,0,1-1-1v0A7,7,0,0,1,12,13Z" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path></svg>';
                            }
                        
                            $html .= '</div>';
                        }
                        

                            $html .= '
                        </div>

                        <svg class="user-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="6" r="4" fill="#000000"></circle> <path d="M20 17.5C20 19.9853 20 22 12 22C4 22 4 19.9853 4 17.5C4 15.0147 7.58172 13 12 13C16.4183 13 20 15.0147 20 17.5Z" fill="#000000"></path></svg>    
                        <p class="number">' . htmlspecialchars($groupMembersNmbr) . ' membres</p>
                    </div>
                    <div class="start-mobile">
                        <span class="' . htmlspecialchars($groupName) . '" id="startGroupDiscussion">Commencer à discuter</span>
                        <span class="group-id hide">' . htmlspecialchars($groupId) . '</span>
                    </div>
                </div>
                <div class="members-names-container">';

                    $query = "SELECT first_name FROM users WHERE id IN ($idsString)";
                    $result2 = $conn->query($query);

                    while ($user = $result2->fetch_assoc()) {
                        $html .= '<span>' . htmlspecialchars($user["first_name"]) . '</span>';
                    }

                    $html .= '
                </div>
            </div>
            <div class="group-actions">
                <svg class="plus" fill="#69E13F" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M19.75 16c0 2.071-1.679 3.75-3.75 3.75s-3.75-1.679-3.75-3.75c0-2.071 1.679-3.75 3.75-3.75s3.75 1.679 3.75 3.75zM19.75 27c0 2.071-1.679 3.75-3.75 3.75s-3.75-1.679-3.75-3.75c0-2.071 1.679-3.75 3.75-3.75s3.75 1.679 3.75 3.75zM19.75 5c0 2.071-1.679 3.75-3.75 3.75s-3.75-1.679-3.75-3.75c0-2.071 1.679-3.75 3.75-3.75s3.75 1.679 3.75 3.75z"></path></svg>
                <div class="start">
                    <span class="' . htmlspecialchars($groupName) . '" id="startGroupDiscussion">Commencer à discuter</span>
                    <span class="group-id hide">' . htmlspecialchars($groupId) . '</span>
                </div>
                <div class="popup-group-options">
                    <span class="leave-group">Quitter le groupe</span>
                    <div class="modif-group-options-container">
                        <span class="modif-group-name">Changer le nom du groupe</span>
                        <form class="modif-group-options-input-container hide" action="" method="POST">
                            <input type="text" class="modif-group-name-text" style="pointer-events: auto;">
                            <input type="submit" class="modif-group-name-submit" value="Changer" style="pointer-events: auto;">
                        </form>
                    </div>
                    <div class="modif-group-options-container">
                        <span class="modif-group-image">Changer l\'image du groupe</span>
                    </div>
                </div>
            </div>
        </div>
        ';

        echo $html;

    };

} else {
    echo "Vous n'avez pas encore de groupes";
};

    $conn->close();
?>