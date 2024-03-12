import {
    ColumnDef,
    flexRender,
    getCoreRowModel,
    useReactTable,
  } from "@tanstack/react-table"
   
  import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
  } from "@breeze/ui/table"


interface DataTableProps<TData, TValue> {
    columns: ColumnDef<TData, TValue>[]
    data: TData[]
  }

export function UserBaseTable<TData, TValue>({columns, data}: DataTableProps<TData, TValue>) {
    const table = useReactTable({
        data,
        columns,
        getCoreRowModel:getCoreRowModel()
    })

    return (
        <div className="rounded-md border max-w-custom mx-auto bg-red-700">
            <Table>
                <TableHeader>
                    {table.getHeaderGroups().map(headerGroup => {
                        return (
                            <TableRow key={headerGroup.id}>
                                {headerGroup.headers.map(header => {
                                    return (
                                        <TableHead key={header.id}>
                                            {flexRender(header.column.columnDef.header, header.getContext())}
                                        </TableHead>
                                    )
                                })}
                            </TableRow>
                        )
                    })}
                </TableHeader>

                <TableBody>
                    {table.getRowModel().rows?.length ? (
                        table.getRowModel().rows.map(row => (
                            <TableRow key={row.id}>
                                {row.getVisibleCells().map(cell => (
                                    <TableCell key={cell.id}>
                                        {flexRender(cell.column.columnDef.cell, cell.getContext())}
                                    </TableCell>
                                ))}
                         </TableRow>
                     ))
                    ): (
                            <TableRow>
                                <TableCell>No Results</TableCell>
                            </TableRow>
                    )}
                </TableBody>
            </Table>
        </div>
    )
}

export default UserBaseTable