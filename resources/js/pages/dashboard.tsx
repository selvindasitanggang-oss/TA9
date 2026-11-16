import AppLayout from '@/layouts/app-layout';
import { Head, Link, usePage } from '@inertiajs/react';
import { ArrowRight, BookOpen, ClipboardList, Users } from 'lucide-react';

export default function Dashboard({ stats }: { stats: { books: number; stock: number; loans: number; activeLoans: number } }) {
    const role = usePage<any>().props.role;
    const cards = [
        { title: 'Judul buku', value: stats.books, icon: BookOpen, color: 'bg-blue-100 text-blue-700' },
        { title: 'Total stok', value: stats.stock, icon: BookOpen, color: 'bg-violet-100 text-violet-700' },
        { title: 'Total peminjaman', value: stats.loans, icon: ClipboardList, color: 'bg-amber-100 text-amber-700' },
        { title: 'Sedang dipinjam', value: stats.activeLoans, icon: ClipboardList, color: 'bg-rose-100 text-rose-700' },
    ];

    return (
        <AppLayout>
            <Head title="Dashboard SiPustaka" />
            <main className="space-y-8 p-6 md:p-8">
                <div>
                    <p className="text-sm font-medium text-muted-foreground">SiPustaka · Perpustakaan Kampus</p>
                    <h1 className="mt-1 text-3xl font-bold">Dashboard</h1>
                    <p className="mt-2 text-muted-foreground">Ringkasan koleksi buku dan aktivitas peminjaman.</p>
                </div>
                <section className="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    {cards.map(({ title, value, icon: Icon, color }) => (
                        <article key={title} className="rounded-xl border bg-card p-5 shadow-sm">
                            <div className="flex items-center justify-between"><span className="text-sm text-muted-foreground">{title}</span><span className={`rounded-lg p-2 ${color}`}><Icon className="size-5" /></span></div>
                            <p className="mt-4 text-3xl font-bold">{value}</p>
                        </article>
                    ))}
                </section>
                <section className="grid gap-4 md:grid-cols-2">
                    <Link href="/buku" className="group rounded-xl border bg-card p-6 transition hover:border-primary/50 hover:shadow-sm"><div className="flex items-center justify-between"><div><h2 className="font-semibold">Katalog Buku</h2><p className="mt-1 text-sm text-muted-foreground">Lihat koleksi dan ketersediaan buku.</p></div><BookOpen className="size-6 text-primary" /></div><span className="mt-5 inline-flex items-center gap-2 text-sm font-medium">Buka katalog <ArrowRight className="size-4 transition group-hover:translate-x-1" /></span></Link>
                    <Link href="/peminjaman" className="group rounded-xl border bg-card p-6 transition hover:border-primary/50 hover:shadow-sm"><div className="flex items-center justify-between"><div><h2 className="font-semibold">Peminjaman</h2><p className="mt-1 text-sm text-muted-foreground">Catat dan kelola transaksi peminjaman.</p></div><ClipboardList className="size-6 text-primary" /></div><span className="mt-5 inline-flex items-center gap-2 text-sm font-medium">Buka peminjaman <ArrowRight className="size-4 transition group-hover:translate-x-1" /></span></Link>
                    {role === 'admin' && <Link href="/users" className="group rounded-xl border bg-card p-6 transition hover:border-primary/50 hover:shadow-sm"><div className="flex items-center justify-between"><div><h2 className="font-semibold">Kelola Pengguna</h2><p className="mt-1 text-sm text-muted-foreground">Atur akun anggota dan hak akses.</p></div><Users className="size-6 text-primary" /></div><span className="mt-5 inline-flex items-center gap-2 text-sm font-medium">Buka pengguna <ArrowRight className="size-4 transition group-hover:translate-x-1" /></span></Link>}
                </section>
            </main>
        </AppLayout>
    );
}
