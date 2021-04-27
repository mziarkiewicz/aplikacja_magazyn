<div class="container">
    {if $msgs->isError()}
        <h4>Lista błędów:</h4>
        <ol>
            {foreach $msgs->getMessages() as $msg}
                <li>{$msg->text}</li>
            {/foreach}
        </ol>
    {/if}

    {if $msgs->isInfo()}
        <ul class="alt">
            <h4>Lista informacji:</h4>
            <ol>
                {foreach $msgs->getMessages() as $msg}
                    <li>{$msg->text}</li>
                {/foreach}
            </ol>
        </ul>
    {/if}
</div>