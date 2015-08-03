<div id="content">
    <div id="main-menu">
        <ul>
            <li><a href="main">Home</a></li>
            <li><a href="forum">Forum</a></li>
            <li><a href="blog">Blog</a></li>
            <li><a href="about">About</a></li>
            <li class="rigth"><a href="auth?_me">Auth</a>|<a href="auth?_new_user">Register</a></li>
        </ul>
        <div class="cleaner"></div>
    </div>
    <div class="content-box">
        <div class="content-title"><a href="#">SimpleText is the native text editor...</a><div style="font-weight: normal; color: #666" class="rigth">#999</div></div>
        <div class="content-text"><p>
                SimpleText is the native text editor for the Apple Macintosh OS in versions before OS X.[1] SimpleText allows editing including text formatting (underline, italic, bold, etc.), fonts, and sizes. It was developed to integrate the features included in the different versions of TeachText that were created by various software development groups within Apple.[2]
                It can be considered similar to Windows' WordPad application. In later versions it also gained additional read only display capabilities for PICT files, as well as other Mac OS built-in formats like Quickdraw GX and QTIF, 3DMF and even QuickTime movies.[2] SimpleText can even record short sound samples and, using Apple's PlainTalk speech system, read out text in English. Users who wanted to add sounds longer than 24 seconds, however, needed to use a separate program to create the sound and then paste the desired sound into the document using ResEdit.[2]
                SimpleText evolved from TeachText,[3] which was derived from the Edit (application), a simple text editor distributed with the earliest Macintosh operating systems to demonstrate the use of the Macintosh interface and the TextEdit application programming interface.<br><br> The need for SimpleText arose after Apple stopped bundling MacWrite, to ensure that every user could open and read Readme documents.
                The key improvement between SimpleText and TeachText was the addition of text styling. SimpleText could support multiple fonts and font sizes, while TeachText supported only a single font per document. Adding text styling features made SimpleText WorldScript-savvy, meaning that it can use Simplified and Traditional Chinese characters.[4] Like TeachText, SimpleText was also limited to only 32 kB of text in a document,[2] although images could increase the total file size beyond this limit. <br><br> SimpleText style information was stored in the file's resource fork in such a way that if the resource fork was stripped (such as by uploading to a non-Macintosh server), the text information would be retained.
                In Mac OS X, SimpleText is replaced by the more powerful TextEdit application, which reads and writes more document formats as well as including word processor-like features such as a ruler and spell checking. TextEdit's styled text format is RTF, which is able to survive a single-forked file system intact.
                Apple has released the source code for a Carbon version of SimpleText in the Panther (10.3) Developer Tools. If the Developer Tools are installed, it can be found at /Developer/Examples/Carbon/SimpleText.</p>
        </div>
        <div class="content-info"><div class="left">Added: 10.06.2015 by <a href="#">Linxon</a></div><div class="rigth"><a href="">Read more...</a></div></div>
        <div class="cleaner"></div>
    </div>
    <div class="separator"></div>

    <div class="bor-title"><h4>Add comment:</h4></div>  

    <div id="com-enter-post-form">
        <form action="" method="POST">
            <textarea placeholder="Enter post..." id="com-enter-post-form-message" name="post_comment"></textarea>
            <div class="com-enter-post-form-btns"><input id="com-enter-post-form-btn1" value="Send" type="submit" name="enter-post"/></div>
        </form>
    </div>
    <div class="bor-title"><h4>Comments:</h4></div>  
    <!-- END/Content -->


    <?php
    $post = new Sys\Wigets\Comment(array());

    $post->showComments();
    ?>

    <!-- Comment box -->
    <div class="comment-box">
        <div class="comment-title">
            <span><div class="com-rate-up"></div><div class="com-rate-down"></div></span>
            <span class="com-tree-control-btl">[ - ]</span>
            <span><a href="#">Linxon</a></span>
            <span class="com-point-stat">2 points</span>
            <span class="com-last-time">54 minutes ago</span>
        </div>
        <div class="toggle">
            <div class="comment-text">
                Comment text
            </div>
            <div class="comment-options">
                <span>Adv</span>
                <span>Adv</span>
                <span>Adv</span>
                <span><b><a id="com-reply-post" href="#">Reply</a></b></span>
                <span>hide child comments</span>
            </div>
            <div class="com-reply-box">
                <div id="com-enter-reply-form">
                    <form action="" method="POST">
                        <textarea placeholder="Enter post..." id="com-enetr-reply-message" name="post_comment"></textarea>
                        <div class="com-enter-post-form-btns">
                            <input id="btn-enter-post" type="submit" value="Send" name="enter-post"/>
                            <input type="button" name="cancel" value="Cancel">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END/Comment box -->

    <div class="com-separator"></div>

    <!-- Footer -->
    <div id="footer">
        <div style="float: left;padding: 9px">Copyright &copy; <a href="#">Simple.com</a></div>
        <div id="main-menu">
            <ul class="rigth">
                <li><a href="main">Home</a></li>
                <li><a href="forum">Forum</a></li>
                <li><a href="blog">Blog</a></li>
                <li><a href="about">About</a></li>
            </ul>
            <div class="cleaner"></div>
        </div>
    </div>
</div>