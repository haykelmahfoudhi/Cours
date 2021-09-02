<?php
/**
 * Created by PhpStorm.
 * User: mahfoudhi
 * Date: 28/0/2021
 * Time: 10:29
 */


class CoursModele
{

    private $dbc;

    function __construct()
    {
        global $dbc;
        $this->dbc = $dbc;

    }

    /**
     * @return mixed
     */
    function SelectCours($DVSE_CODE)
    {
        if ($sqlSelect = $this->dbc->prepare("SELECT * FROM COURS_DEVISE
                                                        WHERE
                                                    CODE_DVSE_CODE = :DVSE_CODE AND
                                                    DT_CRE IS NOT NULL AND
                                                    CODE_COURS_OUT IS NOT NULL
                                                    ORDER BY DT_CRE DESC"))
        {
            $sqlSelect->bindValue(':DVSE_CODE', $DVSE_CODE, PDO::PARAM_STR);
            $sqlSelect->execute();
            $cours = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);
            $sqlSelect->closeCursor();

            return $cours;

        }
        else
        {
            die("Erreur d'accès a la bd!");
        }
    }

    /**
     * @return mixed
     */
    function CoursInsert($CODE_DVSE_CODE, $CODE_DEBUT_VALIDITE, $CODE_FIN_VALIDITE, $CODE_COURS_OUT)
    {
        if ($sqlInsert = $this->dbc->prepare("INSERT INTO COURS_DEVISE (CODE_DVSE_CODE, CODE_DEBUT_VALIDITE, CODE_FIN_VALIDITE, CODE_COURS_IN, CODE_COURS_OUT)
                                                         VALUES (:CODE_DVSE_CODE, TO_DATE(:CODE_DEBUT_VALIDITE, 'YYYY-MM-DD'), TO_DATE(:CODE_FIN_VALIDITE, 'YYYY-MM-DD'), 1, :CODE_COURS_OUT )"))
        {
            $sqlInsert->bindValue(':CODE_DVSE_CODE', $CODE_DVSE_CODE, PDO::PARAM_STR);
            $sqlInsert->bindValue(':CODE_DEBUT_VALIDITE', $CODE_DEBUT_VALIDITE, PDO::PARAM_STR);
            $sqlInsert->bindValue(':CODE_FIN_VALIDITE', $CODE_FIN_VALIDITE, PDO::PARAM_STR);
            $sqlInsert->bindValue(':CODE_COURS_OUT', $CODE_COURS_OUT, PDO::PARAM_INT);
            $cours = $sqlInsert->execute();
            $sqlInsert->closeCursor();

            return $cours;

        }
        else
        {
            die("Erreur d'accès a la bd!");
        }
    }




}


    ?>
