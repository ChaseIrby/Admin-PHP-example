<?php

	//error reporting
	error_reporting(E_ALL|E_STRICT);
	ini_set('display_errors', 'stderr');
	ini_set('display_startup_errors', true);

	$cname = "cookie_name";
	
	require_once( 'DB.php' );
	require_once( 'checkAdmin.php' );
	
	function determinePathCreate($whatToDo, $db)
	{
		//when an instructor/administrator visits admin.php?func=c, the page falls into this switch
		switch ($whatToDo)
		{
			case "default":
				//this case shouldn't happen under any circumstance due to the onchange element
				break;
				
			case "class":
			//if the instructor/adminstrator chose "class" in the create dropdown, 
			//   the page generates the following form prompting for a class ID and name
			//   upon submission, a postback is generated to admin.php?func=cc which calls
			//   createClass with the create_a_class and create_a_class_descrip as parameters
				echo "<form action='admin.php?func=cc' method='post'>";
				echo "<p>Class ID (Ex. ITEC220): ";
				echo "<input type='text' name='create_a_class' maxlength='7'></p>";
				echo "<p>Class Name (Ex. Software Eng II): ";
				echo "<input type='text' name='create_a_class_descrip' maxlength='40'></p>";
				echo "<input type='submit' value='Create'>";
				echo "</form>";
				break;
				
			case "topic":
			//if the instructor/adminstrator chose "topic" in the create dropdown, 
			//   the page generates the following form prompting for a class ID
			//	 to place the new topic under and a topic name
			//   upon submission, a postback is generated to admin.php?func=ct which calls
			//   createTopic with the create_a_topics_class and create_a_topics_topic as parameters
				echo "<form action='admin.php?func=ct' method='post'>";
				echo "<p>Class: ";
				echo "<select name='create_a_topics_class' required>";
				updateClassDropdown($db);
				echo "</select></p>";
				echo "<p>Topic Name (Ex. Algorithms): ";
				echo "<input type='text' name='create_a_topics_topic' maxlength='30'></p>";
				echo "<input type='submit' value='Create'>";
				echo "</form>";
				break;
				
			case "question":
			//if the instructor/adminstrator chose "question" in the create dropdown, 
			//   the page generates the following form prompting for a class to place the question under
			//   upon submission, a postback is generated to admin.php?func=cq which calls
			//   questionCreateCascade with the create_a_questions_class as a parameter
				echo "<form action='admin.php?func=cq' method='post'>";
				echo "<p>Class: ";
				echo "<select name='create_a_questions_class' required onchange='this.form.submit()'>";
				updateClassDropdown($db);
				echo "</select></p>";
				echo "<input type='submit' value='Submit'>";
				echo "</form>";
				break;
		}
	}
	
	function determinePathEdit($whatToDo, $db)
	{
		switch ($whatToDo)
		{
			case "-------":
				//this case shouldn't happen under any circumstance
				break;
			case "class":
			//if the instructor/adminstrator chose "class" in the edit dropdown, 
			//   the page generates the following form prompting for a class ID
			//   upon submission, a postback is generated to admin.php?func=ec which calls
			//   classEditCascade with the edit_a_class as a parameter
				echo "<form action='admin.php?func=ec' method='post'>";
				echo "<p>Select a class to edit: ";
				echo "<select name='edit_a_class' required onchange='this.form.submit()'>";
				updateClassDropdown($db);
				echo "</select></p>";
				echo "<input type='submit' value='Submit'></form>";
				break;
			case "topic":
			//if the instructor/adminstrator chose "topic" in the edit dropdown, 
			//   the page generates the following form prompting for a class ID
			//   upon submission, a postback is generated to admin.php?func=et which calls
			//   topicEditCascadeOne with the edit_a_topics_class as a parameter
				echo "<form action='admin.php?func=et' method='post'>";
				echo "<p>Select a class to edit a topic from: ";
				echo "<select name='edit_a_topics_class' required onchange='this.form.submit()'>";
				echo updateClassDropdown($db);
				echo "</select></p>";
				echo "<input type='submit' value='Submit'></form>";
				break;
			case "question":
			//if the instructor/adminstrator chose "question" in the edit dropdown, 
			//   the page generates the following form prompting for a class ID
			//   upon submission, a postback is generated to admin.php?func=eq which calls
			//   questionEditCascadeOne with the edit_a_questions_class as a parameter
				echo "<form action='admin.php?func=eq' method='post'>";
				echo "<p>Select a class to edit a question from: ";
				echo "<select name='edit_a_questions_class' required onchange='this.form.submit()'>";
				echo updateClassDropdown($db);
				echo "</select></p>";
				echo "<input type='submit' value='Submit'></form>";
				break;
		}
	}
	
	function determinePathDelete($whatToDo, $db)
	{
		switch ($whatToDo)
		{
			case "-------":
				//this case shouldn't happen under any circumstance
				break;
			case "class":
			//if the instructor/adminstrator chose "class" in the delete dropdown, 
			//   the page generates the following form prompting for a class ID
			//   upon submission, a postback is generated to admin.php?func=dc which calls
			//   deleteClass with the delete_a_class and "no" as parameters
				echo "<form action='admin.php?func=dc' method='post'>";
				echo "<p>Select a class to delete: ";
				echo "<select name='delete_a_class' required onchange='this.form.submit()'>";
				updateClassDropdown($db);
				echo "</select></p>";
				echo "<input type='submit' value='Submit'></form>";
				break;
			case "topic":
			//if the instructor/adminstrator chose "topic" in the delete dropdown, 
			//   the page generates the following form prompting for a class ID
			//   upon submission, a postback is generated to admin.php?func=dt which calls
			//   topicDeleteCascade with the delete_a_topics_class as a parameter
				echo "<form action='admin.php?func=dt' method='post'>";
				echo "<p>Select a class to delete a topic from: ";
				echo "<select name='delete_a_topics_class' required onchange='this.form.submit()'>";
				updateClassDropdown($db);
				echo "</select></p>";
				echo "<input type='submit' value='Submit'></form>";
				break;
			case "question":
			//if the instructor/adminstrator chose "class" in the delete dropdown, 
			//   the page generates the following form prompting for a class ID
			//   upon submission, a postback is generated to admin.php?func=dq which calls
			//   questionDeleteCascadeOne with the delete_a_questions_class as a parameter
				echo "<form action='admin.php?func=dq' method='post'>";
				echo "<p>Select a class to delete a question from: ";
				echo "<select name='delete_a_questions_class' required onchange='this.form.submit()'>";
				updateClassDropdown($db);
				echo "</select></p>";
				echo "<input type='submit' value='Submit'></form>";
				break;
		}
	}
	
	function createClass($className, $classDescrip, $db)
	{
		//this function is in charge of creating the class provided by the user
		//   first, a check is ran to see if the class provided already exists or not
		//   if not, the INSERT is ran and the user is provided with feedback
		$test = "SELECT * FROM classes WHERE classid='".$className."'";
		$queryTest = mysqli_query($db, $test);
		if(mysqli_num_rows($queryTest) == 0)
		{
			$createC = "INSERT INTO classes (classid, name) VALUES ('".$className."','".$classDescrip."')";
			$queryC = mysqli_query($db, $createC);
			$queryTest = mysqli_query($db, $test);
			if(mysqli_num_rows($queryTest) == 1)
			{	
				return "Class successfully created!";
			}
			else
			{
				return "Class creation failure!";
			}
		}
		else
		{
			return "Duplicate class detected!";
		}
	}
	
	function createTopic($class, $topicName, $db)
	{
		//this function is in charge of creating the topic provided by the user within
			//   the class determined by the user
			//   first, a check is ran to see if the topic provided already exists or not
			//   if not, the INSERT is ran and the user is provided with feedback
		$test = "SELECT * FROM topics WHERE classid='".$class."' AND topicid='".$topicName."'";
		$queryTest = mysqli_query($db, $test);
		if(mysqli_num_rows($queryTest) == 0)
		{
			$createT = "INSERT INTO topics (classid, topicid) VALUES ('".$class."','".$topicName."')";
			$queryT = mysqli_query($db, $createT);
			$queryTest = mysqli_query($db, $test);
			if(mysqli_num_rows($queryTest) == 1)
			{
				return "Topic successfully created!";
			}
			else
			{
				return "Topic creation failure!";
			}
		}
		else
		{
			return "Duplicate topic detected!";
		}
	}
	
	function createQuestion($class, $topic, $question, $a1, $a2, $a3, $a4, $ra, $db)
	{
		//this function is in charge of creating the question provided by the user within
			//   the class and topic determined by the user
			//   first, a check is ran to see if the question provided already exists or not
			//   if not, the INSERT is ran and the user is provided with feedback
		$test = "SELECT * FROM questions WHERE classid='".$class."' AND topicid='".$topic."' AND question='".$question."'";
		$queryTest = mysqli_query($db, $test);
		//echo $queryTest;
		if(mysqli_num_rows($queryTest) == 0)
		{
			$createQ = "INSERT INTO questions (classid, topicid, question, answer1, answer2, answer3, answer4, rightanswer) VALUES ('".$class."','"
																																	  .$topic."','"
																																	  .$question."','"
																																	  .$a1."','"
																																	  .$a2."','"
																																	  .$a3."','"
																																	  .$a4."','"
																																	  .$ra."')";
			$queryQ = mysqli_query($db, $createQ);
			$queryTest = mysqli_query($db, $test);
			if(mysqli_num_rows($queryTest) == 1)
			{
				return "Question successfully created!";
			}
			else
			{
				return "Question creation failure!";
			}
		}
		else
		{
			return "Duplicate question detected!";
		}
	}
	
	function questionCreateCascade($class, $db)
	{
		//after the user has selected a class to create a question in, this form is generated
		//   to prompt for a topic within the class to add the question to as well as gather
		//   information for all fields to INSERT the question, submission pushes the information
		//   to admin.php?func=cq&c=$class where createQuestion is finally called
		echo "<p>Class chosen: <b>".$class."</b></p>";
		echo "<form action='admin.php?func=cq&c=".$class."' method='post'>";
		echo "<p>Topic: ";
		echo "<select name='create_a_questions_topic' required>";
		updateTopicDropdown($class, $db);
		echo "</select></p>";
		echo "<p>Question: <input type='text' name='question' maxlength='255'></p>";
		echo "<p>Answer 1: <input type='text' name='answer1' maxlength='255'>";
		echo "&nbsp;&nbsp;Answer 2: <input type='text' name='answer2' maxlength='255'></p>";
		echo "<p>Answer 3: <input type='text' name='answer3' maxlength='255'>";
		echo "&nbsp;&nbsp;Answer 4: <input type='text' name='answer4' maxlength='255'></p>";
		echo "<p>Correct answer: <select name='right_answer' required>";
		echo "<option value='1'>1</option>";
		echo "<option value='2'>2</option>";
		echo "<option value='3'>3</option>";
		echo "<option value='4'>4</option>";
		echo "</select></p>";
		echo "<input type='submit' value='Create'>";
		echo "</form>";
	}
	
	function classEditCascade($class, $db)
	{
		//after the user has selected a class to edit, this form is generated
		//   to prompt for edits to be made to the class, submission pushes info to
		//   admin.php?func=ec&go=y where editClass is called (contains UPDATE query)
		$findClass = "SELECT * FROM classes WHERE classid='".$class."'";
		$queryClass = mysqli_query($db, $findClass);
		$row = mysqli_fetch_assoc($queryClass);
		echo "<p>Class chosen: <b>".$class."</b></p>";
		echo "<p>Class name: <b>".$row['name']."</b></p>";
		echo "<form action='admin.php?func=ec&go=y' method='post'>";
		echo "<p>Enter new class ID (Ex. ITEC109): ";
		echo "<input type='text' name='newClassID' maxlength='7'></p>";
		echo "<input type='hidden' name='class' value='".$class."'>";
		echo "<p>Enter new class name (Ex. Software Eng III): ";
		echo "<input type='text' name='newClassName' maxlength='40'></p>";
		echo "<input type='hidden' name='name' value='".$row['name']."'>";
		echo "<p style='color:red'>ATTENTION: Leave a field blank if no change is desired.</p>";
		echo "<input type='submit' value='Commit'>";
		echo "</form>";
		
	}
	
	function topicEditCascadeOne($class, $db)
	{
		//after the user has selected a class to edit a topic from, this form is generated
		//   to prompt for a topic to be edited, submission pushes the selection, along with
		//   the class name to admin.php?func=ett where topicEditCascadeTwo is called
		echo "<form action='admin.php?func=ett' method='post'>";
		echo "<p>Select a topic from <b>".$class."</b> to edit: ";
		echo "<select name='edit_a_topics_topic' required onchange='this.form.submit()'>";
		updateTopicDropdown($class, $db);
		echo "</select></p>";
		echo "<input type='hidden' name='class' value='".$class."'>";
		echo "<input type='submit' value='Submit'></form>";
	}
	
	function topicEditCascadeTwo($class, $topic, $db)
	{
		//after the user has selected the topic to edit from within the class passed,
		//   this form is generated to receive the edits and submission pushes the information
		//   to admin.php?func=ett&go=y where the editClass function is finally called
		//   (contains UPDATE query)
		echo "<p>Editing <b>".$topic."</b> topic from <b>".$class."</b>.";
		echo "<form action='admin.php?func=ett&go=y' method='post'>";
		echo "<p>Enter a new topic name: ";
		echo "<input type='text' name='newTopicID' maxlength='30'></p>";
		echo "<input type='hidden' name='class' value='".$class."'>";
		echo "<input type='hidden' name='topic' value='".$topic."'>";
		echo "<p style='color:red'>ATTENTION: Leave a field blank if no change is desired.</p>";
		echo "<input type='submit' value='Commit'></form>";
	}
	
	function questionEditCascadeOne($class, $db)
	{
		//after the user has selected a class to edit a question from, this form is
		//   generated to prompt the user for a topic from that class to edit a question from
		//   submission pushes the choice to admin.php?func=eqt where questionEditCascadeTwo
		//   is called
		echo "<form action='admin.php?func=eqt' method='post'>";
		echo "<p>Select a topic from <b>".$class."</b> to edit a question from: ";
		echo "<select name='edit_a_questions_topic' required onchange='this.form.submit()'>";
		updateTopicDropdown($class, $db);
		echo "</select></p>";
		echo "<input type='hidden' name='class' value='".$class."'>";
		echo "<input type='submit' value='Submit'></form>";
	}
	
	function questionEditCascadeTwo($class, $topic, $db)
	{
		//after the user has selected a class and topic to edit a question from, this form
		//   is generated to prompt for a question to edit, submission sends the choice to
		//   admin.php?func=eqtq where a form with edits is generated
		echo "<form action='admin.php?func=eqtq' method='post'>";
		echo "<p>Select a question from topic <b>".$topic."</b> in <b>".$class."</b> to edit: </p>";
		generateQuestionRadioList($class, $topic, $db);
		echo "<input type='hidden' name='class' value='".$class."'>";
		echo "<input type='hidden' name='topic' value='".$topic."'>";
		echo "<input type='submit' value='Submit'></form>";
	}
	
	function questionEditCascadeThree($class, $topic, $question, $db)
	{
		//after the user has selected a class and topic to edit a question from, and the 
		//    question itself, this form takes edits that the user wishes to make and passes
		//    them to admin.php?func=eqtq&go=y where editQuestion is called and the UPDATE
		//    query is called
		$findQ = "SELECT * FROM questions WHERE questionid='".$question."'";
		$queryQ = mysqli_query($db, $findQ);
		$row = mysqli_fetch_assoc($queryQ);
		echo "<p>Current values for the chosen question are: </p><br>";
		echo "<p>Question: ".$row['question']."</p>";
		echo "<p>Answer 1: ".$row['answer1']."</p>";
		echo "<p>Answer 2: ".$row['answer2']."</p>";
		echo "<p>Answer 3: ".$row['answer3']."</p>";
		echo "<p>Answer 4: ".$row['answer4']."</p>";
		echo "<p>Right answer: ".($row['rightanswer']==$row['answer1']?"1":($row['rightanswer']==$row['answer2']?"2":($row['rightanswer']==$row['answer3']?"3":"4")))."</p><br><br>";
		echo "<p>Edits: </p><br>";
		echo "<form action='admin.php?func=eqtq&go=y' method='post'>";
		echo "<p>Question: <input type='text' name='newQuestion' maxlength='255'></p>";
		echo "<p>Answer 1: <input type='text' name='newAnswer1' maxlength='255'></p>";
		echo "<p>Answer 2: <input type='text' name='newAnswer2' maxlength='255'></p>";
		echo "<p>Answer 3: <input type='text' name='newAnswer3' maxlength='255'></p>";
		echo "<p>Answer 4: <input type='text' name='newAnswer4' maxlength='255'></p>";
		echo "<p>Right answer: <select name='newRightAnswer' required>";
		echo "<option value='1'>1</option>";
		echo "<option value='2'>2</option>";
		echo "<option value='3'>3</option>";
		echo "<option value='4'>4</option>";
		echo "</select></p>";
		echo "<input type='hidden' name='class' value='".$class."'>";
		echo "<input type='hidden' name='topic' value='".$topic."'>";
		echo "<input type='hidden' name='questionid' value='".$question."'>";
		echo "<p style='color:red'>ATTENTION: Leave a field blank if no change is desired.</p>";
		echo "<input type='submit' value='Commit'></form>";
	}
	
	function topicDeleteCascade($class, $db)
	{
		//after the user has chosen a class to delete a topic from, this form is generated
		//   to prompt the user for a topic to delete - the choice is sent to admin.php?func=dtt
		//   where deleteTopic is called with the chosen class/topic and "no" parameters
		echo "<form action='admin.php?func=dtt' method='post'>";
		echo "<p>Select a topic from <b>".$class."</b> to delete: ";
		echo "<select name='delete_a_topic' required onchange='this.form.submit()'>";
		updateTopicDropdown($class, $db);
		echo "</select></p>";
		echo "<input type='hidden' name='class' value='".$class."'>";
		echo "<input type='submit' value='Submit'></form>";
	}
	
	function questionDeleteCascadeOne($class, $db)
	{
		//after the user has selected a class to delete a question from, this form is
		//   generated to prompt the user for a topic from that class to delete a question from
		//   submission pushes the choice to admin.php?func=dqt where questionDeleteCascadeTwo
		//   is called
		echo "<form action='admin.php?func=dqt' method='post'>";
		echo "<p>Select a topic from <b>".$class."</b> to delete a question from: ";
		echo "<select name='delete_a_questions_topic' required onchange='this.form.submit()'>";
		updateTopicDropdown($class, $db);
		echo "</select></p>";
		echo "<input type='hidden' name='class' value='".$class."'>";
		echo "<input type='submit' value='Submit'></form>";
	}
	
	function questionDeleteCascadeTwo($class, $topic, $db)
	{
		//after the user has selected a class and topic to delete q eustion from, this form is
		//    generated to prompt the user for which question they want to delete
		//    choice is pushed to admin.php?func=dqtq where deleteQuestion is called with
		//    the class, topic, and question choices along with "no"
		echo "<form action='admin.php?func=dqtq' method='post'>";
		echo "<p>Select a question from topic <b>".$topic."</b> in <b>".$class."</b> to delete: </p>";
		generateQuestionRadioList($class, $topic, $db);
		echo "<input type='hidden' name='class' value='".$class."'>";
		echo "<input type='hidden' name='topic' value='".$topic."'>";
		echo "<input type='submit' value='Submit'></form>";
	}
	
	function editClass($class, $name, $newID, $newName, $db)
	{
		//this function is in charge of the UPDATE query associated with a class
		//   since both fields could be potentially blank when submitted, a check
		//   is ran initially to see if any changes are necessary, if either field
		//   is storing a value to replace the old value, the UPDATE is ran on all tables
		//   where that class is present
		if($newID==""&&$newName=="")
		{
			return "No changes were made.";
		}
		else
		{
			$IDChange1 = "UPDATE classes SET classid='".($newID==""?$class:$newID)."', name='".($newName==""?$name:$newName)."' WHERE classid='".$class."'";
			$queryID1 = mysqli_query($db, $IDChange1);
			$test = "SELECT classid FROM topics WHERE classid='".$class."'";
			$queryTest = mysqli_query($db, $test);
			if(mysqli_num_rows($queryTest) > 0)
			{
				$IDChange2 = "UPDATE topics SET classid='".($newID==""?$class:$newID)."' WHERE classid='".$class."'";
				$queryID2 = mysqli_query($db, $IDChange2);
				$moreTest = "SELECT classid FROM questions WHERE classid='".$class."'";
				$queryMoreTest = mysqli_query($db, $moreTest);
				if(mysqli_num_rows($queryMoreTest) > 0)
				{
					$IDChange3 = "UPDATE questions SET classid='".($newID==""?$class:$newID)."' WHERE classid='".$class."'";
					$queryID3 = mysqli_query($db, $IDChange3);
					return "Updated the classes, topics, and questions tables.";
				}
				else
				{
					return "Updated the classes and topics tables.";
				}
			}
			else
			{
				return "Updated the classes table.";
			}
		}
	}
	
	function editTopic($class, $topic, $newTopicID, $db)
	{
		//this function is in charge of the UPDATE query associated with a topic
		//   since the fields could be potentially blank when submitted, a check
		//   is ran initially to see if any changes are necessary, if the field
		//   is storing a value to replace the old value, the UPDATE is ran on all tables
		//   where that topic is present
		if($newTopicID=="")
		{
			return "No changes were made.";
		}
		else
		{
			echo $class;
			echo $topic;
			echo $newTopicID;
			$IDChange1 = "UPDATE topics SET topicid='".$newTopicID."' WHERE classid='".$class."' AND topicid='".$topic."'";
			$queryIDChange1 = mysqli_query($db, $IDChange1);
			$test = "SELECT topicid FROM questions WHERE classid='".$class."' AND topicid='".$topic."'";
			$queryTest = mysqli_query($db, $test);
			if(mysqli_num_rows($queryTest) > 0)
			{
				$IDChange2 = "UPDATE questions SET topicid='".$newTopicID."' WHERE classid='".$class."' AND topicid='".$topic."'";
				$queryIDChange2 = mysqli_query($db, $IDChange2);
				return "Updated the topics and questions tables.";
			}
			else
			{
				return "Updated the topics table.";
			}
		}
	}
	
	function editQuestion($questionid, $newQ, $newA1, $newA2, $newA3, $newA4, $newRA, $db)
	{
		//this function is in charge of the UPDATE query associated with a question
		//   since the new rightanswer is actually just a number, a check is ran to see
		//   if the passed answer x is blank or not, if it is, UPDATE will be ran with the
		//   old rightanswer resubmitted
		$findQ = "SELECT * FROM questions WHERE questionid='".$questionid."'";
		$queryQ = mysqli_query($db, $findQ);
		$row = mysqli_fetch_assoc($queryQ);
		switch ($newRA)
		{
			case "1":
				if($newA1=="")
				{
					$temp = $row['answer1'];
				}
				else
				{
					$temp = $newA1;
				}
				break;
			case "2":
				if($newA2=="")
				{
					$temp = $row['answer2'];
				}
				else
				{
					$temp = $newA2;
				}
				break;
			case "3":
				if($newA3=="")
				{
					$temp = $row['answer3'];
				}
				else
				{
					$temp = $newA3;
				}
				break;
			case "4":
				if($newA4=="")
				{
					$temp = $row['answer4'];
				}
				else
				{
					$temp = $newA4;
				}
				break;
		}
		
		$editQ = "UPDATE questions SET question='".($newQ==""?$row['question']:$newQ).
									"', answer1='".($newA1==""?$row['answer1']:$newA1).
									"', answer2='".($newA2==""?$row['answer2']:$newA2).
									"', answer3='".($newA3==""?$row['answer3']:$newA3).
									"', answer4='".($newA4==""?$row['answer4']:$newA4).
									"', rightanswer='".$temp."' WHERE questionid='".$questionid."'";
		$queryEditQ = mysqli_query($db, $editQ);
		return "Question changed successfully.";
	}
	
	function deleteClass($class, $confirm, $db)
	{
		//this function governs the DELETE query associated with a class
		//    this function is first called with "no" so that a form confirmation
		//    can be generated in order to promote user forgiveness
		//    if the user confirms the deletion, the class and all representations of it
		//    are removed from the database
		if($confirm=="yes")
		{
			$deleteClass1 = "DELETE FROM questions WHERE classid='".$class."'";
			$deleteClass2 = "DELETE FROM topics WHERE classid='".$class."'";
			$deleteClass3 = "DELETE from classes WHERE classid='".$class."'";
			$queryDC1 = mysqli_query($db, $deleteClass1);
			$queryDC2 = mysqli_query($db, $deleteClass2);
			$queryDC3 = mysqli_query($db, $deleteClass3);
			$test = "SELECT classid FROM classes WHERE classid='".$class."'";
			$queryTest = mysqli_query($db, $test);
			if(mysqli_num_rows($queryTest) == 0)
			{
				return "Successfully deleted class: <b>".$class."</b>";
			}
			else
			{
				return "There was an error trying to delete class: <b>".$class."</b>";
			}
		}
		else
		{
			echo "<p>Are you sure you wish to delete <b>".$class."</b>?</p>";
			echo "<form action='admin.php?func=dc&go=y' method='post'>";
			echo "<input type='hidden' name='class' value='".$class."'>";
			echo "<input type='submit' value='Yes'></form>";
			echo "<form action='admin.php?func=d' method='post'>";
			echo "<input type='submit' value='No'></form>";
			
		}
	}
	
	function deleteTopic($class, $topic, $confirm, $db)
	{
		//this function governs the DELETE query associated with a topic
		//    this function is first called with "no" so that a form confirmation
		//    can be generated in order to promote user forgiveness
		//    if the user confirms the deletion, the topic and all representations of it
		//    are removed from the database
		if($confirm=="yes")
		{
			$deleteTopic1 = "DELETE FROM questions WHERE classid='".$class."' AND topicid='".$topic."'";
			$deleteTopic2 = "DELETE FROM topics WHERE classid='".$class."' AND topicid='".$topic."'";
			$queryDT1 = mysqli_query($db, $deleteTopic1);
			$queryDT2 = mysqli_query($db, $deleteTopic2);
			$test = "SELECT topicid FROM topics WHERE classid='".$class."' AND topicid='".$topic."'";
			$queryTest = mysqli_query($db, $test);
			if(mysqli_num_rows($queryTest) == 0)
			{
				return "Successfully deleted topic: <b>".$topic."</b>";
			}
			else
			{
				return "There was an error trying to delete topic: <b>".$topic."</b>";
			}
		}
		else
		{
			echo "<p>Are you sure you wish to delete topic <b>".$topic."</b> from <b>".$class."</b>?</p>";
			echo "<form action='admin.php?func=dtt&go=y' method='post'>";
			echo "<input type='hidden' name='class' value='".$class."'>";
			echo "<input type='hidden' name='topic' value='".$topic."'>";
			echo "<input type='submit' value='Yes'></form>";
			echo "<form action='admin.php?func=d' method='post'>";
			echo "<input type='submit' value='No'></form>";
		}
	}
	
	function deleteQuestion($class, $topic, $questionid, $confirm, $db)
	{
		//this function governs the DELETE query associated with a question
		//    this function is first called with "no" so that a form confirmation
		//    can be generated in order to promote user forgiveness
		//    if the user confirms the deletion, the question is removed from the database
		if($confirm=="yes")
		{
			$deleteQuestion = "DELETE FROM questions WHERE questionid='".$questionid."'";
			$queryDeleteQ = mysqli_query($db, $deleteQuestion);
			$test = "SELECT question FROM questions WHERE questionid='".$questionid."'";
			$queryTest = mysqli_query($db, $test);
			if(mysqli_num_rows($queryTest)==0)
			{
				return "Successfully deleted the question.";
			}
			else
			{
				return "There was an error trying to delete the question.";
			}
		}
		else
		{
			$findQ = "SELECT question FROM questions WHERE questionid='".$questionid."'";
			$queryQ = mysqli_query($db, $findQ);
			$row = mysqli_fetch_assoc($queryQ);
			echo "<p>Are you sure you wish to delete question <b>".$row['question']."</b> from topic <b>".$topic."</b> / <b>".$class."</b>?</p>";
			echo "<form action='admin.php?func=dqtq&go=y' method='post'>";
			echo "<input type='hidden' name='class' value='".$class."'>";
			echo "<input type='hidden' name='topic' value='".$topic."'>";
			echo "<input type='hidden' name='question' value='".$questionid."'>";
			echo "<input type='submit' value='Yes'></form>";
			echo "<form action='admin.php?func=d' method='post'>";
			echo "<input type='submit' value='No'></form>";
		}
	}
	
	function createInstructor($user, $y, $db)
	{
		//this function oversees the flagging of a user as an instructor
		//   the function is initially called with "n" so that they can be confirmed
		//   as an actual user, and a form confirmation can be generated to promote
		//   user forgiveness
		if($y == "y")
		{
			$test = "SELECT * FROM users WHERE username='".$user."'";
			$queryTest = mysqli_query($db, $test);
			$row = mysqli_fetch_assoc($queryTest);
			if($row['isInstructor'] == 1)
			{
				return "That user is already an instructor!";
			}
			else
			{
				$flagUser = "UPDATE users SET isInstructor='1' WHERE username='".$user."'";
				$queryFlag = mysqli_query($db, $flagUser);
				$queryAgain = mysqli_query($db, $test);
				$row = mysqli_fetch_assoc($queryAgain);
				if($row['isInstructor'] == 1)
				{
					return "User ".$user." has been successfully flagged as an instructor!";
				}
				else
				{
					return "Failure occurred trying to convert ".$user." to an instructor!";
				}
			}
		}
		else
		{
			$test = "SELECT * FROM users WHERE username='".$user."'";
			$queryTest = mysqli_query($db, $test);
			if(mysqli_num_rows($queryTest) == 0)
			{
				return "That user does not exist!";
			}
			else
			{
				echo '<p>Are you sure you want to make '.$user.' an instructor-level user?</p>';
				echo '<form action="admin.php?func=iiy&u='.$user.'" method="post">';
				echo '<input type="submit" value="Yes">';
				echo '</form>';
				echo '<form action="admin.php?func=i" method="post">';
				echo '<input type="submit" value="No">';
				echo '</form>';
			}
		}
	}
	
	function updateClassDropdown($db)
	{
		//this function just generates the class options for a dropdownlist
		$findClasses = "SELECT * FROM classes";
		$queryClasses = mysqli_query($db, $findClasses);
		while($row = mysqli_fetch_assoc($queryClasses))
		{
			echo '<option value="'.$row['classid'].'">'.$row['classid'].'</option>';
		}
	}
	
	function updateTopicDropdown($class, $db)
	{
		//this function just generates the topic options for a dropdownlist associated
		//   with a specific class
		$findTopics = "SELECT * FROM topics WHERE classid='".$class."'";
		$queryTopics = mysqli_query($db, $findTopics);
		while($row = mysqli_fetch_assoc($queryTopics))
		{
			echo '<option value="'.$row['topicid'].'">'.$row['topicid'].'</option>';
		}
	}
	
	function updateQuestionDropdown($class, $topic, $db)
	{
		//this function just generates the question options for a dropdownlist associated
		//   with a specific class and topic - it is never used
		$findQuestions = "SELECT question FROM questions WHERE classid='".$class."' AND topicid='".$topic."'";
		$queryQuestions = mysqli_query($db, $findQuestions);
		while($row = mysqli_fetch_assoc($queryQuestions))
		{
			echo '<option value="'.$row['questionid'].'">'.$row['question'].'</option>';
		}
	}
	
	function generateQuestionRadioList($class, $topic, $db)
	{
		//this function just generates the question radio list associated with
		//   a specific class and topic
		$findQuestions = "SELECT question,questionid FROM questions WHERE classid='".$class."' AND topicid='".$topic."'";
		$queryQuestions = mysqli_query($db, $findQuestions);
		while($row = mysqli_fetch_assoc($queryQuestions))
		{
			echo '<input type="radio" name="question" value="'.$row['questionid'].'">'.$row['question'].'<br>';
		}
	}
	
	function flagInstructorForm($db)
	{
		//this function generates a form to prompt the user for a username to flag
		//   as an instructor
		echo '<form action="admin.php?func=ii" method="post">';
		echo '<p>WARNING: Ensure that the username is correct!</p>';
		echo '<p>Enter a username: ';
		echo '<input type="text" name="flaggedUser" maxlength="30"></p>';
		echo '<input type="submit" value="Flag Instructor">';
	}

	function initialFormGen($userLevel)
	{
		//this function is in charge of generating the initial form on visiting admin.php
		//   assuming the user passes the instructor check, the form is generated with three 
		//   dropdowns, each dropdown for create/edit/delete has class/topic/question
		//   on change, a dropdown will generate a postback with func=c for create, func=e for edit, and func=d for delete
		//   if the user is flagged as an admin, they can also choose to flag other users as instructors
		echo '<form action="admin.php?func=c" method="post">';
		echo '<p>Create a: ';
		echo '<select name="create_dropdown" onchange="this.form.submit()">';
		echo '<option value="default">-------</option>';
		echo '<option value="class">Class</option>';
		echo '<option value="topic">Topic</option>';
		echo '<option value="question">Question</option>';
		echo '</select></p>';
		echo '</form><br>';
			
		echo '<form action="admin.php?func=e" method="post">';
		echo '<p>Edit a: ';
		echo '<select name="edit_dropdown" onchange="this.form.submit()">';
		echo '<option value="default">-------</option>';
		echo '<option value="class">Class</option>';
		echo '<option value="topic">Topic</option>';
		echo '<option value="question">Question</option>';
		echo '</select></p>';
		echo '</form><br>';
			
		echo '<form action="admin.php?func=d" method="post">';
		echo '<p>Delete a: ';
		echo '<select name="delete_dropdown" onchange="this.form.submit()">';
		echo '<option value="default">-------</option>';
		echo '<option value="class">Class</option>';
		echo '<option value="topic">Topic</option>';
		echo '<option value="question">Question</option>';
		echo '</select></p>';
		echo '</form>';
		
		if($userLevel == "super")
		{
			echo '<br><form action="admin.php?func=i" method="post">';
			echo '<input type="submit" value="Flag an instructor">';
			echo '</form>';
		}
	}

?>

<html lang="en-US">
<head>
	<title>RUStudying</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/RUStudying.css">
	<?php
		echo "<script>var valid ='".$valid."';</script>";
	?>
	<script>
		if(valid != "super" && valid != "admin")
		{
			window.location = "login.php";
		}
	</script>
</head>

<body>

	<?php
	?>

	<!-- <script src="js/jquery.js">  </script>
	<script src="js/bootstrap.min.js">  </script> -->

	<div id="container">
	
		<!-- this is the entire navbar -->
		<nav role="navigation" class="navbar navbar-default">
		
			<div id="banner">
				<img src="Banner.png" alt="RUStudying!?!"/>
			</div>
			
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			
				<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="home.php" class="navbar-brand">RUStudying</a>
				
			</div>
			
			<!-- Collection of nav links, forms, and other content for toggling -->
			<div id="navbarCollapse" class="collapse navbar-collapse">
				<!-- Unordered list containing all links to be displayed in the navbar -->
				<ul class="nav navbar-nav">
					<li><a href="home.php">Home</a></li>
					<?php
						if($valid == "super" || $valid == "admin")
							echo '<li class="active"><a href="admin.php">Admin</a></li>';
					?>
				</ul>
				<!-- Another unordered list containing the last link to be displayed in the navbar -->
				<ul class="nav navbar-nav navbar-right">
					<?php
						if (isset($_COOKIE[$cname])) 
						{
							echo '<li><a href="logout.php">Logged in as ' . $_COOKIE[$cname] . ', logout?</a></li>';
						} 
						else 
						{
							echo '<li><a href="login.php">Login</a></li>';
						} 
					?>
				</ul>
				
			</div>
			
		</nav>
		
		<!-- this div is where everything not a banner or footer goes i.e. the main part of a page
			 "content2" is different from "content" in that it has some padding added to keep it in
		     line with text on the "content" pages. They'd be off by about a half-inch otherwise -->
		<div id="content">
		
			<?php 
				//primary check to see if the user visits the page fresh
				if(!isset($_GET['func']))
				{
					initialFormGen($valid);
				}
				else
				{
					$func = $_GET['func'];
					$status = "";
					//switch statement that changes the functionality of the page based on what is assigned
					//   to 'func' in the URL
					switch ($func)
					{
						case "c":
							$creator = $_POST['create_dropdown'];
							determinePathCreate($creator, $conn);
							break;
						case "e":
							$editor = $_POST['edit_dropdown'];
							determinePathEdit($editor, $conn);
							break;
						case "d":
							$destroyer = $_POST['delete_dropdown'];
							determinePathDelete($destroyer, $conn);
							break;
						case "i":
							flagInstructorForm($conn);
							break;
						case "cc":
							$status = createClass($_POST['create_a_class'],$_POST['create_a_class_descrip'],$conn);
							break;
						case "ct":
							$status = createTopic($_POST['create_a_topics_class'],$_POST['create_a_topics_topic'],$conn);
							break;
						case "cq":
							if(isset($_GET['c']))
							{
								$classN = ($_GET['c']);
								$temp = "";
								switch ($_POST['right_answer'])
								{
									case '1':
										$temp = $_POST['answer1'];
										break;
									case '2':
										$temp = $_POST['answer2'];
										break;
									case '3':
										$temp = $_POST['answer3'];
										break;
									case '4':
										$temp = $_POST['answer4'];
										break;
								}
								$status = createQuestion($classN,
														 $_POST['create_a_questions_topic'],
														 $_POST['question'],
														 $_POST['answer1'],
														 $_POST['answer2'],
														 $_POST['answer3'],
														 $_POST['answer4'],
														 $temp,
														 $conn);
							}
							else
							{
								questionCreateCascade($_POST['create_a_questions_class'],$conn);
							}
							break;
						case "ec":
							if(isset($_GET['go']))
							{
								$status = editClass($_POST['class'], $_POST['name'], $_POST['newClassID'], $_POST['newClassName'], $conn);
							}
							else
							{
								classEditCascade($_POST['edit_a_class'],$conn);
							}
							break;
						case "et":
							topicEditCascadeOne($_POST['edit_a_topics_class'],$conn);
							break;
						case "eq":
							questionEditCascadeOne($_POST['edit_a_questions_class'],$conn);
							break;
						case "dc":
							$status = deleteClass((isset($_GET['go'])?$_POST['class']:$_POST['delete_a_class']), (isset($_GET['go'])?"yes":"no"), $conn);
							//do something about deleting a class
							break;
						case "dt":
							topicDeleteCascade($_POST['delete_a_topics_class'], $conn);
							break;
						case "dq":
							questionDeleteCascadeOne($_POST['delete_a_questions_class'], $conn);
							break;
						case "ii":
							$status = createInstructor($_POST['flaggedUser'], "n", $conn);
							break;
						case "iiy":
							$status = createInstructor($_GET['u'], "y", $conn);
							break;
						case "ett":
							if(isset($_GET['go']))
							{
								$status = editTopic($_POST['class'], $_POST['topic'], $_POST['newTopicID'], $conn);
							}
							else
							{
								topicEditCascadeTwo($_POST['class'], $_POST['edit_a_topics_topic'], $conn);
							}
							break;
						case "eqt":
							questionEditCascadeTwo($_POST['class'], $_POST['edit_a_questions_topic'], $conn);
							break;
						case "eqtq":
							if(isset($_GET['go']))
							{
								$status = editQuestion($_POST['questionid'],
													   $_POST['newQuestion'], 
													   $_POST['newAnswer1'], 
													   $_POST['newAnswer2'], 
													   $_POST['newAnswer3'], 
													   $_POST['newAnswer4'], 
													   $_POST['newRightAnswer'], 
													   $conn);
							}
							else
							{
								questionEditCascadeThree($_POST['class'], $_POST['topic'], $_POST['question'], $conn);
							}
							break;
						case "dtt":
							$status = deleteTopic($_POST['class'],(isset($_GET['go'])?$_POST['topic']:$_POST['delete_a_topic']),(isset($_GET['go'])?"yes":"no"), $conn);
							break;
						case "dqt":
							questionDeleteCascadeTwo($_POST['class'],$_POST['delete_a_questions_topic'], $conn);
							break;
						case "dqtq":
							$status = deleteQuestion($_POST['class'],$_POST['topic'], $_POST['question'], (isset($_GET['go'])?"yes":"no"), $conn);
							break;
						default:
							$status = "Epic switch failure!";
							break;
					}
					echo '<p>'.$status.'</p>';
				}
				
			?>
			
		</div>
		
		<!-- this push div pushes the page down further past the content so that anything within
			 the content div is never displayed behind the footer and therefore invisible -->
		<div id="push"></div>
		
	</div>
	
	<!-- sticky footer! -->
	<div id="footer">
		<span><img src="bootstrap-solid.svg" alt="Bootstrap icon"/>&nbsp;&nbsp;Website by <b>Highlanders Care to Cure</b></span>
		<a href="mailto:softeng05@radford.edu">Contact Us</a>
	</div>

</body>
</html>