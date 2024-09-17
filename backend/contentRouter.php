<!-- File for redirection to the appropriate content based on get requests. -->
<?php
    //If the content requested is the home/dashboard.
    if($_GET['content'] == "home") {
        include_once('./dashboard/header.php');
        include_once('./dashboard/actionpanel.php');

        //The following are hidden for our final presentation because they were not yet implemented.

        //include_once('./components/dashboard/feed.php');
        //include_once('./components/dashboard/recentworkflows.php');
        //include_once('./components/dashboard/recentmessages.php');
    }
    //If the content requested is the search page.
    else if($_GET['content'] == "search") {
        //If the user requested the a specific section of the search page.
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == "user") {
                include_once("./userfunctions/search/searchUser.php");
            }
            else if($_GET['contentType'] == "workflows") {
                include_once("./userfunctions/search/searchWorkflow.php");
            }
            else if($_GET['contentType'] == "jobs") {
                include_once("./userfunctions/search/searchJobs.php");
            }
            else if($_GET['contentType'] == "steps") {
                include_once("./userfunctions/search/searchTasks.php");
            }
            else if($_GET['contentType'] == "templates") {
                include_once("./userfunctions/search/searchTemplates.php");
            }
            else if($_GET['contentType'] == "workflowtemplate") {
                include_once("./userfunctions/search/searchWorkflowTemplates.php");
            }
            else if($_GET['contentType'] == "industry") {
                include_once("./userfunctions/search/searchDepartment.php");
            }
            else if($_GET['contentType'] == "course") {
                include_once("./userfunctions/search/searchCourse.php");
            }
            /*else if($_GET['contentType'] == "steps") {
                include_once("./userfunctions/search/searchSteps.php");
            }*/
            else if($_GET['contentType'] == "tasktemplates") {
                include_once("./userfunctions/search/searchTaskTemplates.php");
            }
           /* else if($_GET['contentType'] == "templates") {
                include_once("./userfunctions/search/searchTemplates.php");
            }*/
        }
        else {
            include_once("./userfunctions/search/search.php");
        }
    }
    //If the content requested is the create page.
    else if($_GET['content'] == "create") {
        //If the user requested the a specific section of the create page.
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == "user") {
                include_once("./userfunctions/create/createUser.php");
            }
            else if($_GET['contentType'] == "workflow") {
                include_once("./userfunctions/create/createWorkflow.php");
            }
            else if($_GET['contentType'] == "department") {
                include_once("./userfunctions/create/createDepartment.php");
            }
            else if($_GET['contentType'] == "course") {
                include_once("./userfunctions/create/createCourse.php");
            }
			else if($_GET['contentType'] == "message") {
                include_once("./userfunctions/create/createMessage.php");
            }
			else if($_GET['contentType'] == "app") {
                include_once("./userfunctions/create/createApp.php");
            }
        }
        else {
            include_once("./userfunctions/create/create.php");
        }
    }
        //If the content requested is the full calendar page.
    else if($_GET['content'] == "calendar") {
        include_once("./calendar.php");
    }

    else if($_GET['content'] == "messages") {
            include_once("./userfunctions/messages.php");
        }
    else if($_GET['content']== 'deleted')
    {
        include_once("./userfunctions/view/deletedMessages.php");
    }
        else if($_GET['content'] == "allmessages") {
            include_once("./userfunctions/messages.php");
        }
    else if($_GET['content']== 'sentmessages')
    {
        include_once("./userfunctions/view/sentMessages.php");
    }
    else if($_GET['content'] == "archivedmessages")
    {
        include_once("./userfunctions/view/archivedMessages.php");
    }
    else if($_GET['content'] == "files") {
        include_once("./userfunctions/file/files.php");
    }
    else if($_GET['content'] == "upload") {
        include_once("./userfunctions/file/uploadFile.php");
    }
    else if($_GET['content'] == "updateFile") {
        include_once("./userfunctions/file/updateFile.php");
    }
    else if($_GET['content'] == "removeFile") {
        include_once("./userfunctions/file/removeFile.php");
    }
    else if($_GET['content'] == "deleteFile") {
        include_once("./userfunctions/file/deleteFile.php");
    }

    //If the content requested is one of the many misc sidebar items.
    else if($_GET['content'] == "miscFunc") {
        //If the user requested the a specific section of the create page.
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == "admin") {
                include_once("./userfunctions/miscFunc/adminTools.php");
            }
            else if($_GET['contentType'] == "users") {
                 include_once("./userfunctions/miscFunc/users.php");
            }
        }
        else {//return home if requested incorrectly
            include_once('./dashboard/header.php');
            include_once('./dashboard/actionpanel.php');
        }
    }
    else if($_GET['content'] == "jobs") {
        //If the user requested the a specific section of the workflows page.
        include_once("./userfunctions/jobs/view-all-jobs.php");
    }
    if(isset($_GET['viewType'])) {
        if($_GET['viewType'] == "list") {

        }
    }
    else if($_GET['content'] == "jobtemplate") {
        include_once("./userfunctions/jobs/view-all-job-templates-table.php");
     
    }
    else if($_GET['content'] == "tasktemplate") {
        include_once("./userfunctions/jobs/view-all-task-templates-table.php");
    }
    else if($_GET['content'] == "newtemplate") {
        include_once("./userfunctions/jobs/create-job-template.php");
    }
    else if($_GET['content'] == "jobslist") {
        include_once("./userfunctions/jobs/view-jobs-table.php");
    }
    else if($_GET['content'] == "viewjob") {
        include_once("./userfunctions/jobs/view-one-job.php");
    }
    else if($_GET['content'] == "newjob") {
        include_once("./userfunctions/jobs/create-job.php");
    }
    /*else if($_GET['content'] == "taskslist") {
        include_once("./userfunctions/jobs/view-tasks-table.php");
    }*/
   /* else if($_GET['content'] == "tasks") {
        include_once("./userfunctions/jobs/view-all-tasks.php");
    }*/
    else if($_GET['content'] == "jobsteplist") {
        include_once("./userfunctions/jobs/view-tasks-table.php");
    }
    else if($_GET['content'] == "jobsteps") {
        include_once("./userfunctions/jobs/view-all-tasks.php");
    }
    else if($_GET['content'] == "onejob" && isset($_GET['job_id'])) {
        include_once("./userfunctions/jobs/view-one-job.php?job_id=".$_GET['job_id']);
    }
    else if($_GET['content'] == "jobgraph") {
        include_once("./userfunctions/jobs/job-graph-view.php");
    }
    else if($_GET['content'] == "assigntasks") {
        include_once("./userfunctions/jobs/assign-tasks.php");
    }
    else if($_GET['content'] == "archivedjobs") {
        include_once("./userfunctions/jobs/view-archive-jobs.php");
    }
    else if($_GET['content'] == "archivedjobslist") {
        include_once("./userfunctions/jobs/view-archive-list.php");
    }
    //If the content requested is the workflows page.
    else if($_GET['content'] == "workflows") {
        //If the user requested the a specific section of the workflows page.
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == "active") {
                include_once("./userfunctions/workflows/activeWorkflows.php");

            if (isset($_GET['viewForm'])) {

                if($_GET['viewForm'] == 'true') {
                    include_once("./form/chooseForm.php");
                    }
                }
            }
            else if($_GET['contentType'] == "new") {
                include_once("./userfunctions/workflows/newWorkflows.php");
            }
            else if($_GET['contentType'] == "start") {
                include_once("./userfunctions/workflows/startWorkflow.php");
            }
            else if($_GET['contentType'] == "completed") {
                include_once("./userfunctions/workflows/completedWorkflows.php");
            }
            else if($_GET['contentType'] == "viewWorkflow") {
                include_once("./userfunctions/workflows/viewWorkflow.php");
            }

        }
        else {
            include_once("./userfunctions/workflows/workflows.php");

            if ( isset($_GET['formType'])) {

                if ($_GET['formType'] == 'secretary') {
                    include_once("./form/secretaryForm.php");
                }
                else if ($_GET['formType'] == 'student') {
                    include_once("./form/studentForm.php");
                }
                else if ($_GET['formType'] == 'student') {
                    include_once("./form/studentForm.php");
                }
                else if ($_GET['formType'] == 'faculty') {
                    include_once("./form/instructorForm.php");
                }
                else if ($_GET['formType'] == 'dean' || $_GET['formType'] == 'chair') {
                    include_once("./form/deanForm.php");
                }
                else if ($_GET['formType'] == 'chair' || $_GET['formType'] == 'chair') {
                    include_once("./form/chairForm.php");
                }
                else if ($_GET['formType'] == 'supervisor' || $_GET['formType'] == 'chair') {
                    include_once("./form/supervisorForm.php");
                }
            }
        }
    }

    //TEMP BANDAID SOLUTION TO FORMS
    else if($_GET['content'] == "forms") {
        //If the user requested the a specific section of the workflows page.
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == "create") {
                include_once("./userfunctions/forms/createNewForm.php");
            }
            else if($_GET['contentType'] == "edit") {
                include_once("./userfunctions/forms/editForm.php");
            }
            else if($_GET['contentType'] == "view") {
                include_once("./userfunctions/forms/viewAllForms.php");
            }
            else if($_GET['contentType'] == "viewForm") {
                include_once("./userfunctions/forms/viewForm.php");
            }
            else if($_GET['contentType'] == "removeForm") {
                include_once("./userfunctions/forms/removeForm.php");
            }
            else if($_GET['contentType'] == "delete") {
                include_once("./userfunctions/forms/deleteForms.php");
            }
            else if($_GET['contentType'] == "editSingle") {
                include_once("./userfunctions/forms/editSingle.php");
            }
            else if($_GET['contentType'] == "testing") {        //new for testing form submissions
                include_once("./userfunctions/forms/viewSubmittedForm.php");
            }
        }
        else {
            include_once("./userfunctions/forms/forms.php");
        }
    }

    //TEMP BANDAID SOLUTION TO COURSES
    else if($_GET['content'] == "courses") {
        //If the user requested the a specific section of the workflows page.
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == "create") {
                include_once("./userfunctions/courses/createCourse.php");
            }
            else if($_GET['contentType'] == "edit") {
                include_once("./userfunctions/courses/editCourse.php");
            }
            else if($_GET['contentType'] == "view") {
                include_once("./userfunctions/courses/viewAllCourses.php");
            }
            else if($_GET['contentType'] == "delete") {
                include_once("./userfunctions/courses/deleteCourse.php");
            }
            else if($_GET['contentType'] == "editSingle") {
                include_once("./userfunctions/courses/editSingle.php");
            }
        }
        else {
            include_once("./userfunctions/courses/courses.php");
        }
    }

    else if($_GET['content'] == "adminTools") {
        //If the user requested the a specific section of the search page.
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == "user") {
                include_once("./userfunctions/create/createUser.php");
            }
            else if($_GET['contentType'] == "industry") {
                include_once("./userfunctions/create/createDepartment.php");
            }
            else if($_GET['contentType'] == "company") {
                include_once("./userfunctions/create/createCourse.php");
            }
        }
        else {
            include_once("./userfunctions/miscFunc/adminTools.php");
        }
    }

    //router for user actions
    else if($_GET['content'] == "users") {

        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == "create") {
                include_once("./userfunctions/create/createUser.php");
            }
            else if($_GET['contentType'] == "view") {
                include_once("./userfunctions/search/searchUser.php");
            }
        }
        else {
            include_once("./userfunctions/miscFunc/users.php");
        }
    }



    //If the content requested is the view page.
    else if($_GET['content'] == "view") {
        //If the user requested the a specific section of the view page.
        if($_GET['contentType'] == "user") {
            include_once("./userfunctions/view/viewUser.php");
        }
        else if($_GET['contentType'] == "workflow") {
            include_once("./userfunctions/view/viewWorkflow.php");
        }
        else if($_GET['contentType'] == "workflowTemplate") {
            include_once("./userfunctions/view/viewWorkflowTemplate.php");
        }
        else if($_GET['contentType'] == "department") {
            include_once("./userfunctions/view/viewDepartment.php");
        }
        else if($_GET['contentType'] == "course") {
            include_once("./userfunctions/view/viewCourse.php");
        }
		else if($_GET['contentType'] == "message") {
            include_once("./userfunctions/view/viewMessage.php");
        }
		else if($_GET['contentType'] == "file") {
            include_once("./userfunctions/view/viewFile.php");
        } 

        else if($_GET['contentType'] == "step") {
            include_once("./userfunctions/view/viewStep.php");
        }
        else if($_GET['contentType'] == "stepTemplate") {
            include_once("./userfunctions/view/viewStepTemplate.php");
        }
    }
    else if($_GET['content'] == "viewWorkflow") {
        include_once("./userfunctions/viewWorkflow.php");
    }
    else if($_GET['content'] == "startInternApp") {
        include_once("./userfunctions/workflows/internAppStart.php");
    }
    else if($_GET['content'] == "settings") {
        if(isset($_GET['contentType'])) {
            if($_GET['contentType'] == 'myAccount') {
                include_once("./userfunctions/settings/viewProfile.php");
            }
            if($_GET['contentType'] == 'changeEmail') {
                include_once("./userfunctions/settings/changeEmail.php");
            }
            if($_GET['contentType'] == 'changePassword') {
                include_once("./userfunctions/settings/changePassword.php");
            }
        }
        else {
            include_once("./userfunctions/settings/settings.php");
        }
    }
     else if($_GET['content'] == "test") {
        include_once("./form/test.php");
     }
      else if($_GET['content'] == "test1") {
        include_once("./form/test1.php");
     }
?>


