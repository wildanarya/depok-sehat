<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelUser extends CI_Model
{
    public function getUser()
    {
        return $this->db->get('user')->result_array();
    }

    public function userWhere($where)
    {
        return $this->db->get_where('user', $where);
    }

    public function getLastIdUser()
    {
        // Mendapatkan ID user terakhir dari database
        $this->db->select('id_user');
        $this->db->order_by('id_user', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('user');

        // Jika tidak ada data user, kita mulai dengan nomor 1
        if ($query->num_rows() == 0) {
            $newIdUser = 'USR001';
        } else {
            $lastId = $query->row()->id_user;
            // Mendapatkan bagian numerik dari ID user terakhir
            $numericPart = intval(substr($lastId, 3));

            // Menambahkan 1 ke bagian numerik
            $newNumericPart = $numericPart + 1;

            // Membuat ID user baru
            $newIdUser = 'USR' . str_pad($newNumericPart, 3, '0', STR_PAD_LEFT);
        }
    }


    public function simpanUserIncrement($data = null)
    {
        // Mendapatkan ID user terakhir dari database
        $this->db->select('id_user');
        $this->db->order_by('id_user', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('user');

        // Jika tidak ada data user, kita mulai dengan nomor 1
        if ($query->num_rows() == 0) {
            $newIdUser = 'USR001';
        } else {
            $lastId = $query->row()->id_user;
            // Mendapatkan bagian numerik dari ID user terakhir
            $numericPart = intval(substr($lastId, 3));

            // Menambahkan 1 ke bagian numerik
            $newNumericPart = $numericPart + 1;

            // Membuat ID user baru
            $newIdUser = 'USR' . str_pad($newNumericPart, 3, '0', STR_PAD_LEFT);
        }

        // Menambahkan ID user baru ke dalam data
        $data['id_user'] = $newIdUser;

        // Memasukkan data ke dalam database
        return $this->db->insert('user', $data);
    }

    public function simpanUser($data = null)
    {
        $this->db->insert('user', $data);
    }

    // public function updateUser($data = null, $where = null)
    // {
    //     $this->db->update('user', $data, $where);
    // }

    public function updateUser($id_user, $data)
    {
        $this->db->where('id_user', $id_user);
        return $this->db->update('user', $data);
    }

    public function deleteUser($id_user)
    {
        $this->db->where('id_user', $id_user);
        return $this->db->delete('user');
    }

    // public function getLastUserNumber() {
    //     $this->db->select_max('id_user');
    //     $result = $this->db->get('user')->row_array();
    //     return $result['id_user'];
    // }


    public function cekData($where = null)
    {
        return $this->db->get_where('user', $where);
    }


    // public function updateUser($data = null, $where = null)
    // {
    //     $this->db->update('user', $data, $where);
    // }

    // public function getUserWhere($where = null)
    // {
    //     $this->db->select_sum($field);
    //     if (!empty($where) && count($where) > 0) {
    //         $this->db->where($where);
    //     }
    //     $this->db->from('user');
    //     return $this->db->get()->row($field);
    // }

    public function getUserWhere($where = null)
    {
        return $this->db->get_where('user', $where);
    }

    public function getUserById($id_user)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('user.id_user', $id_user);
        return $this->db->get()->row_array();
    }


    public function cekUserAccess($where = null)
    {
        $this->db->select('*');
        $this->db->from('access_menu');
        $this->db->where($where);
        return $this->db->get();
    }

    // public function getUserLimit()
    // {
    //     $this->db->select('pasien.*, kecamatan.nama_kecamatan');
    //     $this->db->from('pasien');
    //     $this->db->join('kecamatan', 'pasien.id_kecamatan = kecamatan.id_kecamatan');
    //     $this->db->limit(15); // Batasan 15 entri
    //     return $this->db->get()->result_array();
    // }
}

// ============================================
// KODINGAN CONTEKAN (DIHAPUS DIAKHIR)
// ============================================
// <?php
// defined('BASEPATH') or exit('No direct script access allowed');
// class ModelBanner extends CI_Model
// {
//     public function getBanner()
//     {
//         return $this->db->get('banner');
//     }
//     public function bannerWhere($where)
//     {
//         return $this->db->get_where('banner', $where);
//     }
//     public function simpanBanner($data = null)
//     {
//         $this->db->insert('banner', $data);
//     }

//     public function hapusBanner($where = null)
//     {
//         $this->db->delete('banner', $where);
//     }
//     public function total($field, $where)
//     {
//         $this->db->select_sum($field);
//         if (!empty($where) && count($where) > 0) {
//             $this->db->where($where);
//         }
//         $this->db->from('banner');
//         return $this->db->get()->row($field);
//     }

//     public function getLimitBanner()
//     {
//         $this->db->limit(5);
//         return $this->db->get('banner');
//     }   
// }


// <?php if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');
// class ModelPinjam extends CI_Model
// {
// 	//manip table pinjam
// 	public function simpanPinjam($data)	{ $this->db->insert('pinjam', $data); }

// 	public function selectData($table, $where) { return $this->db->get($table, $where); }

// 	public function updateData($data, $where) { $this->db->update('pinjam', $data, $where); }

// 	public function deleteData($tabel, $where) { $this->db->delete($tabel, $where); }

// 	public function joinData() 
// 	{
// 		$this->db->select('*');
// 		$this->db->from('pinjam');
// 		$this->db->join('detail_pinjam', 'detail_pinjam.no_pinjam=pinjam.no_pinjam', 'Right');

// 		return $this->db->get()->result_array();
// 	}

// 	//manip tabel detai pinjam
// 	public function simpanDetail($idbooking, $nopinjam)
// 	{
// 		$sql = "INSERT INTO detail_pinjam (no_pinjam,id_buku) SELECT pinjam.no_pinjam, booking_detail.id_buku FROM pinjam, booking_detail WHERE booking_detail.id_booking=$idbooking AND pinjam.no_pinjam='$nopinjam'";
// 		$this->db->query($sql);
// 	}
// }


// <?php
// defined('BASEPATH') or exit('No direct script access allowed');

// class ModelBuku extends CI_Model
// {
//     //manajemen buku
//     public function getBuku()
//     {
//         return $this->db->get('buku');
//     }

//     public function bukuWhere($where)
//     {
//         return $this->db->get_where('buku', $where);
//     }

//     public function simpanBuku($data = null)
//     {
//         $this->db->insert('buku',$data);
//     }

//     public function updateBuku($data = null, $where = null)
//     {
//         $this->db->update('buku', $data, $where);
//     }

//     public function hapusBuku($where = null)
//     {
//         $this->db->delete('buku', $where);
//     }

//     public function total($field, $where)
//     {
//         $this->db->select_sum($field);
//         if(!empty($where) && count($where) > 0){
//             $this->db->where($where);
//         }
//         $this->db->from('buku');
//         return $this->db->get()->row($field);
//     }

//     //manajemen kategori
//     public function getKategori()
//     {
//         return $this->db->get('kategori');
//     }

//     public function kategoriWhere($where)
//     {
//         return $this->db->get_where('kategori', $where);
//     }

//     public function simpanKategori($data = null)
//     {
//         $this->db->insert('kategori', $data);
//     }

//     public function hapusKategori($where = null)
//     {
//         $this->db->delete('kategori', $where);
//     }

//     public function updateKategori($where = null, $data = null)
//     {
//         $this->db->update('kategori', $data, $where);
//     }

//     //join
//     public function joinKategoriBuku($where)
//     {
//         $this->db->from('buku');
//         $this->db->join('kategori','kategori.id = buku.id_kategori');
//         $this->db->where($where);
//         return $this->db->get();
//     }

// 	public function getLimitBuku()
// 	{
// 		$this->db->limit(5);
// 		return $this->db->get('buku');
// 	}
// }

// <?php

// class ModelBooking extends CI_Model
// {
// 	public function getData($table)	{ return $this->db->get($table)->row(); }

// 	public function getDataWhere($table, $where)
// 	{
// 		$this->db->where($where);
// 		return $this->db->get($table);
// 	}

// 	public function getOrderByLimit($table, $order, $limit)
// 	{
// 		$this->db->order_by($order, 'desc');
// 		$this->db->limit($limit);
// 		return $this->db->get($table);
// 	}

// 	public function joinOrder($where)
// 	{
// 		$this->db->select('*');
// 		$this->db->from('booking bo');
// 		$this->db->join('booking_detail d', 'd.id_booking=bo.id_booking');
// 		$this->db->join('buku bu ', 'bu.id=d.id_buku');
// 		$this->db->where($where);
// 		return $this->db->get();
// 	}

// 	public function simpanDetail($where = null)
// 	{
// 		$sql = "INSERT INTO booking_detail (id_booking,id_buku) SELECT booking.id_booking, temp.id_buku FROM booking, temp WHERE temp.id_user=booking.id_user AND booking.id_user='$where'";
// 		$this->db->query($sql);
// 	}

// 	public function insertData($table, $data)
// 	{
// 		$this->db->insert($table, $data);
// 	}

// 	public function updateData($table, $data, $where)
// 	{
// 		$this->db->update($table, $data, $where);
// 	}

// 	public function deleteData($where, $table)
// 	{
// 		$this->db->where($where);
// 		$this->db->delete($table);
// 	}

// 	public function find($where)
// 	{
// 		//Query mencari record berdasarkan ID-nya
// 		$this->db->limit(1);
// 		return $this->db->get('buku', $where);
// 	}

// 	public function kosongkanData($table)
// 	{
// 		return $this->db->truncate($table);
// 	}

// 	public function createTemp()
// 	{
// 		$this->db->query('CREATE TABLE IF NOT EXISTS temp(id_booking varchar(12), tgl_booking DATETIME, email_user varchar(128), id_buku int)');
// 	}

// 	public function selectJoin()
// 	{
// 		$this->db->select('*');
// 		$this->db->from('booking');
// 		$this->db->join('booking_detail', 'booking_detail.id_booking=booking.id_booking');
// 		$this->db->join('buku', 'booking_detail.id_buku=buku.id');
// 		return $this->db->get();
// 	}

// 	public function showtemp($where)
// 	{
// 		return $this->db->get('temp', $where);
// 	}

// 	public function kodeOtomatis($tabel, $key)
// 	{
// 		$this->db->select('right(' . $key . ',3) as kode', false);
// 		$this->db->order_by($key, 'desc');
// 		$this->db->limit(1);
// 		$query = $this->db->get($tabel);
// 		if ($query->num_rows() <> 0) 
// 		{
// 			$data = $query->row();
// 			$kode = intval($data->kode) + 1;
// 		} else {
// 			$kode = 1;
// 		}
// 		$kodemax = str_pad($kode, 3, "0", STR_PAD_LEFT);
// 		$kodejadi = date('dmY') . $kodemax;
// 		return $kodejadi;
// 	}
// }
