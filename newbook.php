<?php
$pageTitle='Нова книга';
include 'includes/header.php';
include 'includes/conn.php';
echo '<a href="index.php">Книги</a>';
if($_POST){
             $book = trim($_POST['book']);
             $book = mysqli_real_escape_string($connect,$book);
             $selectedauthors = $_POST['authors'];
             $error = false;
              if(mb_strlen($book)<=3){
                    echo '<p><h2>Името е прекалено късо</h2></p>';
                    $error=true;
                  }
                  if(!$error){
                         if( $sql="SELECT `book_title` FROM `books` WHERE book_title='$book'")
                          {
                                 $result= mysqli_query($connect,$sql);
                                 $count=  mysqli_num_rows($result);
                                 if($count==1){  
                                     echo '<h2>Грешка! Заглавието е вече регистрирано! </h2>';
                                     
                                   }
                                   elseif ($selectedauthors==NULL) {
                                            echo '<h2>Грешка! Избери автор ! </h2>';                         
                                         }
                                 else {$sql='INSERT INTO `books` (`book_title`) VALUES("'.$book.'")';
                                 if(mysqli_query($connect, $sql))
                                     {    
                                    foreach ($selectedauthors as $selectedauthor)
                                        {
                                        $sl='insert into books_authors (author_id, book_id) value ( 
                                            (select author_id from authors where author_name="'.$selectedauthor.'") , (select book_id from books where book_title="'.$book.'"))';
                                        if(!mysqli_query($connect, $sl)){    
                                        echo 'Грешка при добавянето';}
                                         }
                                echo 'Заглавието е успешно добавено';
                                     }
                                 }
                          }
                     } 
   }
         
?>
<form method="POST">
    <div>Заглавие :<input type="text" name="book" /></div>
    <select multiple name="authors[]">
        <?php
            $list= mysqli_query($connect, 'SELECT `author_name` FROM `authors`');
            while($row=$list->fetch_assoc())
                {
                if(!$list){
                    echo 'Грешка в данните';
                  }
                echo '<option value="'.$row['author_name'].'">'.$row['author_name'].'</option>';
                
               
            }
             ?>
    </select> 
    <div><input type="submit" value="Добави" /></div>
</form>
<?php
include 'includes/footer.php';
?>