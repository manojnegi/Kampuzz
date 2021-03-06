
@extends('layouts.main')

<?php if ($course_name) {
    
            $breadcrumb_t = $course_name->course_name;

            $specialization_filter = $course_name->hasSpecialization->toArray() ;
              $exam_filter = $course_name->hasExams->toArray() ;
        }
        ?> 


  @section('content')


    <div class="row">

        <div id="content_left" class="col-md-9 ">
           
            @section('content_left')
            <div class="rich_editor_text"></div>
            <div class="element_size_100">

                <header class="cs-heading-title">
                    <h2 class="cs-section-title float-left">View Courses</h2>
                </header>
                <div class="event eventlisting">

                    <?php
                    for ($i = 0; $i < count($collegeList);$i++){
                    $detail_url = route('courses.detail', ['slug' => Str::slug($collegeList[$i]['college_name'] . '-' . $collegeList[$i]['course_name']), 'id' => $collegeList[$i]['course_id']]);
                    ?>

                    <article class="events type-events status-publish has-post-thumbnail hentry">
                        <figure>
                            <img src="<?php if ($collegeList[$i]['college_logo'] <> '')
                            {
                                echo $collegeList[$i]['college_logo'];
                            } else
                            {
                                echo asset('images/no-thumb.png');
                            }?>" width="78px" alt="<?php echo $collegeList[$i]['college_name']; ?>"
                                 title="<?php echo $collegeList[$i]['college_name']; ?>">

                        </figure>
                        <div class="text">
                            <div class="event-texttop">
                                <h2 class="cs-post-title">
                                    <a href="<?php echo $detail_url; ?>"
                                       class="colrhvr"><?php echo $collegeList[$i]['college_name']; ?></a>
                                </h2>
                                <h6><?php echo $collegeList[$i]['city_name']; ?>
                                </h6>
                                <ul class="post-categories">
                                    <li><a href="<?php echo $detail_url; ?>"
                                           rel="tag"><?php echo $collegeList[$i]['course_name']; ?></a></li>
                                    <li>
                                        <time><?php  echo General::giveStars($collegeList[$i]['college_rating']);?></time>
                                    </li>
                                </ul>
                            </div>
                            <div class="post-options">
                                <ul>
                                    <li>
                                        <i class="fa fa-clock-o"></i><strong>Duration:</strong><span> <?php if ($collegeList[$i]['duration'] <> '')
                                            {
                                                echo $collegeList[$i]['duration'];
                                            } else if ($collegeList[$i]['course_duration'] <> '')
                                            {
                                                echo $collegeList[$i]['course_duration'];
                                            }?></span></li>

                                    <?php if ($collegeList[$i]['exam_required'] <> '')
                                    {
                                        echo '<li><i class="fa fa-qrcode"></i><strong>Exam:</strong> <span>' . substr($collegeList[$i]['exam_required'], 0, 100) . ' </span></li>';
                                    } ?>
                                    <?php if ($collegeList[$i]['total_fee'] <> '')
                                    {
                                        echo '<li><i class="fa fa-money"></i><strong>Fee:</strong> <span><i class="fa fa-inr"></i>' . $collegeList[$i]['total_fee'] . ' </span></li>';
                                    } ?>
                                    <?php if ($collegeList[$i]['affiliation'] <> '')
                                    {
                                        echo '<li><i class="fa fa-paperclip"></i><strong>Affiliation:</strong> <span>' . strip_tags($collegeList[$i]['affiliation']) . ' </span></li>';
                                    } ?>


                                </ul>
                            </div>
                            <a href="<?php echo $detail_url; ?>" class="btn cs-bgcolr bgcolr view">Details</a>

                        </div>


                    </article>


                    <?php } ?>


                </div>
                {{ $courseColleges->links() }}


            </div>
            @stop
            @yield('content_left')
        </div>
        @unless (Request::ajax())   
        <div id="contetn-right" class="col-md-3 col-sm-4">
            @include('includes.widget_right_bar')
        </div>
        @endunless

    </div>
    <!-- Row End -->
    <script>



    $(document).ready(function() {
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            $(".transparentCover").show();
            $(".loading").show();
            getFilteredList($(this).attr('href'),$(this).attr('href').split('page=')[1]); 
            
        });
    });

    function scrollToElement(ele) {
             $(window).scrollTop(ele.offset().top).scrollLeft(ele.offset().left);
    }

    function getFilteredList(url,page) {
        $.ajax({
            url : url ,
            type: "GET",
            beforeSend: function(xhr){
                            xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
                        },
        }).done(function (data) {
             $(".transparentCover").hide();
            $(".loading").hide();
            $('#content_left').html(data);
            location.hash = 'page='+page;
            scrollToElement($('#content_left'));
        }).fail(function () {
           // alert('Server Busy');
        });
    }

    </script>
@stop


