import { ColumnDef } from "@tanstack/react-table"
import { User } from "../user"

export const columns: ColumnDef<User>[] = [
    {
        header: "Username",
        accessorKey: "user_name"
    },
    {
        header: "Gender",
        accessorKey: "gender"
    },
    {
        header: "City",
        accessorKey: "city"
    },
    {
        header: "Interest",
        accessorKey: "interest"
    },
    {
        header: "Created On",
        accessorKey: "created_on"
    },
]