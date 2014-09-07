        <?php
        $pageTitle='Нов автор';
        include 'includes/header.php';
        include 'includes/conn.php';
        echo '<a href="index.php">Книги</a>';
        if(isset($_GET['sort'])){
            if($_GET['sort']=='asc'){
                $sortFix='desc';
                $sortsql='asc';
            }
            elseif ($_GET['sort']=='desc'){
                $sortFix='asc';
                $sortsql='desc';
            }
          }
           else {
                $sortFix='desc';
                $sortsql='asc';
            }
        if($_POST){
             $author = trim($_POST['author']);
             $author = mysqli_real_escape_string($connect,$author);
             $error = false;
              if(mb_strlen($author)<=3){
                    echo '<p><h2>Името е прекалено късо</h2></p>';
                    $error=true;
                  }
                  if(!$error){
                         if( $sql="SELECT `author_name` FROM `authors` WHERE author_name='$author'" )
                            {
                                 $result= mysqli_query($connect,$sql);
                                 $count=  mysqli_num_rows($result);
                                 if($count==1){  
                                     echo '<h2>Името е заето </h2>';
                                   }
                         else {$sql='INSERT INTO `authors` (`author_name`) VALUES("'.$author.'")';	
                                 if(mysqli_query($connect, $sql)){    
                                     echo '<h2>Авторът е добавен успешно</h2>';}
                            }
                            }
                  } 
        }
        ?>
<form method="POST">
    <div>Автор :<input type="text" name="author" /></div>
    <div><input type="submit" value="Добави" />&nbsp&nbsp<a href="newbook.php">Добави книга</a></div>
</form>
        <?php 
        $list= mysqli_query($connect, 'SELECT `author_name`, author_id FROM `authors`Order by author_name '.$sortsql.'');
       if(!$list){
            echo 'Грешка в данните';
       }echo '<table border="1"><tr><td><b>Автор</b><a href=newauthor.php?sort='.$sortFix.'>Сорт</a></td></tr>';
       while($row=$list->fetch_assoc()){
             echo '<tr><td><a href=authors.php?id='.$row['author_id'].'>'.$row['author_name'].'</a></td></tr>'; 
       } echo '</table>';
include 'includes/footer.php';
?>