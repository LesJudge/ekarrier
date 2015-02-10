<?php
/**
 * Ügyfél mentés interface.
 */
interface IClientSave
{
    /**
     * Példányosít egy objektumot az ügyfél mentéshez.
     * @param mixed $param
     */
    public static function model($param = null);
    /**
     * "Set-up"-olja az objektumot az ügyfél mentéshez.
     * @param \Client $client
     * @return \self
     */
    public function setUpClientSave(\Client $client);
}