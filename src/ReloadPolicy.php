<?php
interface ReloadPolicy
{
    public function shouldReload(\DateTime $loadTime, \DateTime $fetchTime);
}
