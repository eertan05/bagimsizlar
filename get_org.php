<?php
include "img/ph/db_connect.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
      $stmt = $pdo->prepare("
          SELECT
              o.*,
              (
                  SELECT GROUP_CONCAT(bd_fin.bD_trLabel SEPARATOR ', ')
                  FROM baseDictionary bd_fin
                  WHERE FIND_IN_SET(bd_fin.bD_index, o.o_fin)
                  AND bd_fin.bD_property = 'o_fin'
              ) AS o_fin,
              (
                  SELECT GROUP_CONCAT(bd_fow.bD_trLabel SEPARATOR ', ')
                  FROM baseDictionary bd_fow
                  WHERE FIND_IN_SET(bd_fow.bD_index, o.o_fow)
                  AND bd_fow.bD_property = 'o_fow'
              ) AS o_fow,
              (
                  SELECT GROUP_CONCAT(bd_def.bD_trLabel SEPARATOR ', ')
                  FROM baseDictionary bd_def
                  WHERE FIND_IN_SET(bd_def.bD_index, o.o_def)
                  AND bd_def.bD_property = 'o_def'
              ) AS o_def,
              (
                  SELECT GROUP_CONCAT(bd_equ.bD_trLabel SEPARATOR ', ')
                  FROM baseDictionary bd_equ
                  WHERE FIND_IN_SET(bd_equ.bD_index, o.o_equ)
                  AND bd_equ.bD_property = 'o_equ'
              ) AS o_equ,
              (
                  SELECT GROUP_CONCAT(bd_ser.bD_trLabel SEPARATOR ', ')
                  FROM baseDictionary bd_ser
                  WHERE FIND_IN_SET(bd_ser.bD_index, o.o_ser)
                  AND bd_ser.bD_property = 'o_ser'
              ) AS o_ser,
              (
                  SELECT GROUP_CONCAT(bd_tar.bD_trLabel SEPARATOR ', ')
                  FROM baseDictionary bd_tar
                  WHERE FIND_IN_SET(bd_tar.bD_index, o.o_tar)
                  AND bd_tar.bD_property = 'o_tar'
              ) AS o_tar,
              (
                  SELECT GROUP_CONCAT(bd_act.bD_trLabel SEPARATOR ', ')
                  FROM baseDictionary bd_act
                  WHERE FIND_IN_SET(bd_act.bD_index, o.o_act)
                  AND bd_act.bD_property = 'o_act'
              ) AS o_act,

              bd_typ.bD_trLabel AS o_typ,
              bd_leg.bD_trLabel AS o_leg

          FROM orgs o
          LEFT JOIN baseDictionary bd_typ
              ON o.o_typ = bd_typ.bD_index
              AND bd_typ.bD_property = 'o_typ'
          LEFT JOIN baseDictionary bd_leg
              ON o.o_leg = bd_leg.bD_index
              AND bd_leg.bD_property = 'o_leg'
          WHERE o.o_id = ?
      ");

        $stmt->execute([$id]);
        $org = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($org) {
            echo json_encode($org);
        } else {
            echo json_encode(['error' => 'Organization not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}
