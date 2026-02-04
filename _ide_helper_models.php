<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $kode_barang
 * @property string $nama_barang
 * @property EnumsSatuanEnum $satuan
 * @property int $stok
 * @property string $harga_satuan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereHargaSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereStok($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Barang extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeGramasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeGramasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeGramasi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeGramasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeGramasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeGramasi whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class KodeGramasi extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeAnak newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeAnak newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeAnak query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeAnak whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeAnak whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeAnak whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class KodeSizeAnak extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeDewasa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeDewasa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeDewasa query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeDewasa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeDewasa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeDewasa whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class KodeSizeDewasa extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeTintaSablon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeTintaSablon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeTintaSablon query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeTintaSablon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeTintaSablon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeTintaSablon whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class KodeTintaSablon extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nama
 * @property string|null $telepon
 * @property string|null $alamat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Member extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $kode_order
 * @property string $nama_pelanggan
 * @property int $harga_total
 * @property int|null $member_id
 * @property string $status_bayar
 * @property string $tanggal
 * @property string|null $tanggal_selesai
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderanDetail> $details
 * @property-read int|null $details_count
 * @property-read \App\Models\Pembayaran|null $pembayaran
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan whereHargaTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan whereKodeOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan whereNamaPelanggan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan whereStatusBayar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Orderan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $orderan_id
 * @property int $barang_id
 * @property int $jumlah
 * @property string $harga_satuan
 * @property string $subtotal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barang $barang
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail whereBarangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail whereHargaSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail whereOrderanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class OrderanDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $orderan_id
 * @property string $no_nota
 * @property string $tanggal_pembayaran
 * @property string $jumlah_bayar
 * @property string $metode
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Orderan $orderan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereJumlahBayar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereMetode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereNoNota($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereOrderanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereTanggalPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Pembayaran extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaturan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaturan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaturan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaturan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaturan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaturan whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaturan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaturan whereValue($value)
 * @mixin \Eloquent
 */
	class Pengaturan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $role
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

