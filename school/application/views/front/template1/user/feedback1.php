<section role="main" class="content-body">
  <header class="page-header">
      <h2>User Feedback</h2>
      <div class="right-wrapper pull-right">
         <ol class="breadcrumbs">
            <li>
            </li>
         </ol>
      </div>
  </header>
    <form class="" id="add-feedback-frm"  enctype="" action="" method="post" role="form">
      <div class="col-md-6 col-lg-12 col-xl-6">
        <section class="panel panel-primary">  
          <header class="panel-heading">
            
            <h2 class="panel-title">Submit User Feedback </h2>
          </header>
          <div style="display: block;" class="panel-body">
            <?php if($this->session->flashdata('success_message')){ ?>
                <div class="row">
                  <div class="col-md-12">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <div class="alert alert-success"> <?php echo $this->session->flashdata('success_message');?> </div>
                  </div>
                </div>
                <?php } ?>
                <?php if($this->session->flashdata('error_msg')){ ?>
                <div class="row">
                  <div class="col-md-12">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <div class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg');?> </div>
                  </div>
                </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-8">
                       <div id="question_1" value="1"><b>1. Has the Teacher covered relevant topics beyond Syllabus?</b></div>
                    </div>
                    <div class="col-md-8">
                    <textarea class="form-control preview_input" rows="2" id="feedback_answer_1" name="feedback_answer_1" ></textarea>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-8">
                       <p id="question_2"><b>2. Effectiveness of Teacher in terms of Communication skills </b></p>
                    </div>
                    <div class="col-md-8">
                    <textarea class="form-control preview_input" rows="2" id="feedback_answer_2" name="feedback_answer_2" ></textarea>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                       <p id="question_3"><b>3. Effectiveness of Teacher in terms of Availability beyond normal classes and co-operation to solve individual problems </b></p>
                    </div>
                    <div class="col-md-8">
                    <textarea class="form-control preview_input" rows="2" id="feedback_answer_3" name="feedback_answer_3" ></textarea>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-8">
                       <p id="question_4"><b>4. How do you rate the contents of the curricular ? </b></p>
                    </div>
                    <div class="col-md-8">
                    <textarea class="form-control preview_input" rows="2" id="feedback_answer_4" name="feedback_answer_4" ></textarea>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-8">
                       <p id="question_5"><b>5. How do you rate lab facilities, if applicable? </b></p>
                    </div>
                    <div class="col-md-8">
                    <textarea class="form-control preview_input" rows="2" id="feedback_answer_5" name="feedback_answer_5" ></textarea>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-8">
                       <p id="question_6"><b>6. Any other suggestions ?</b></p>
                    </div>
                    <div class="col-md-8">
                    <textarea class="form-control preview_input" rows="3" id="feedback_answer_6" name="feedback_answer_6" ></textarea>
                    </div>
                </div>
          </div>
          <footer style="display: block;" class="panel-footer">
            <button class="btn btn-primary" id="feedback_submit_btn"> Submit </button>
          </footer>   
        </section>    
      
      </div>
    </form>
</section>